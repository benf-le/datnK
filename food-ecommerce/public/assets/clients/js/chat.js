$(document).ready(function () {
    // Cấu hình thư viện marked.js (nếu có) để parse link an toàn
    if (typeof marked !== 'undefined') {
        marked.setOptions({
            breaks: true,
            sanitize: false // cho phép các thẻ HTML cơ bản từ Markdown
        });
    }

    // Toggle đóng mở chat box
    $("#chat-toggle").click(function () {
        $("#chat-box").toggleClass("hidden");
        if ($("#chat-box").hasClass("hidden")) {
            $("#scrollUp").show();
            $("#chat-widget").css("bottom", "140px");
        } else {
            loadMessage();
            $("#scrollUp").hide();
            $("#chat-widget").css("bottom", "20px");
        }
    });

    $("#chat-close").click(function () {
        $("#chat-box").addClass("hidden");
        $("#chat-widget").css("bottom", "140px");
        $("#scrollUp").show();
    });

    // Xử lý gửi tin nhắn
    $("#send-btn").click(function () {
        let msgText = $("#message-input").val().trim();
        if (!msgText) return;

        // 1. Hiển thị tin nhắn của user ngay lập tức lên khung chat
        appendOne({
            sender: "user",
            message: msgText
        });

        // Xóa nội dung trong ô input và vô hiệu hóa các nút nhập để tránh gửi lặp
        $("#message-input").val("").prop("disabled", true);
        $("#send-btn").prop("disabled", true);

        // 2. Hiển thị Typing Indicator (Ba chấm chạy)
        showTypingIndicator();

        // Thiết lập CSRF cho AJAX
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        // 3. Gửi tin nhắn lên server
        $.post("/chat/send", { message: msgText }, function (res) {
            // Xóa Typing Indicator
            hideTypingIndicator();

            // Kích hoạt lại input
            $("#message-input").prop("disabled", false).focus();
            $("#send-btn").prop("disabled", false);

            // Hiển thị tin nhắn trả về từ Bot hoặc làm sạch lịch sử
            if (res.cleared) {
                $("#chat-messages").html("");
                appendOne({
                    sender: "bot",
                    message: "Xin chào 👋! Tôi là trợ lý ảo hỗ trợ tìm kiếm sản phẩm và giải đáp thắc mắc. Tôi có thể giúp gì cho bạn hôm nay?"
                });
            } else if (res.bot) {
                appendOne(res.bot);
            } else {
                console.error("[Chat] Phản hồi /chat/send không hợp lệ:", res);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("[Chat] Gọi /chat/send thất bại:", textStatus, errorThrown, jqXHR.responseText);

            hideTypingIndicator();
            $("#message-input").prop("disabled", false).focus();
            $("#send-btn").prop("disabled", false);

            appendOne({
                sender: "bot",
                message: "Xin lỗi, hệ thống đang gặp lỗi. Bạn vui lòng thử lại sau.",
            });
        });
    });

    // Gửi bằng phím Enter
    $("#message-input").keypress(function (e) {
        if (e.which === 13) {
            $("#send-btn").click();
            return false;
        }
    });

    // Nhấp chuột vào nút gợi ý nhanh (Quick Replies)
    $(document).on("click", ".quick-reply-btn", function () {
        let replyText = $(this).attr("data-reply");
        if (replyText) {
            $("#message-input").val(replyText);
            $("#send-btn").click();
        }
    });

    // Xử lý nút Reset cuộc trò chuyện từ Header
    $(document).on("click", "#chat-reset", function () {
        if (confirm("Bạn có chắc chắn muốn xóa lịch sử trò chuyện và bắt đầu lại không?")) {
            // Xóa ngay lập tức trên UI để người dùng thấy phản hồi nhanh
            $("#chat-messages").html("");
            
            $("#message-input").val("").prop("disabled", true);
            $("#send-btn").prop("disabled", true);
            showTypingIndicator();

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.post("/chat/send", { message: "bắt đầu lại" }, function (res) {
                hideTypingIndicator();
                $("#message-input").prop("disabled", false).focus();
                $("#send-btn").prop("disabled", false);

                // Dù kết quả trả về như thế nào, ta vẫn hiển thị lời chào (vì UI đã xóa từ trước)
                $("#chat-messages").html("");
                appendOne({
                    sender: "bot",
                    message: "Xin chào 👋! Tôi là trợ lý ảo hỗ trợ tìm kiếm sản phẩm và giải đáp thắc mắc. Tôi có thể giúp gì cho bạn hôm nay?"
                });
            }).fail(function () {
                hideTypingIndicator();
                $("#message-input").prop("disabled", false).focus();
                $("#send-btn").prop("disabled", false);
                alert("Không thể xóa lịch sử trò chuyện lúc này. Vui lòng thử lại sau.");
                // Tải lại tin nhắn nếu xóa thất bại để đồng bộ lại
                loadMessage();
            });
        }
    });

    // Hàm load tin nhắn cũ từ server
    function loadMessage() {
        $("#chat-messages").html("");
        // Hiển thị loading nhẹ trong lúc tải tin nhắn cũ
        $("#chat-messages").append(`<div id="chat-history-loading" style="text-align: center; color: #718096; font-size: 12px; padding: 10px;">Đang tải tin nhắn...</div>`);
        
        $.get("/chat/messages", function (msgs) {
            $("#chat-history-loading").remove();

            if (!msgs || msgs.length === 0) {
                appendOne({
                    sender: "bot",
                    message: "Xin chào 👋! Tôi là trợ lý ảo hỗ trợ tìm kiếm sản phẩm và giải đáp thắc mắc. Tôi có thể giúp gì cho bạn hôm nay?"
                });
                return;
            }

            msgs.forEach(function (m) {
                appendOne(m);
            });
            scrollToBottom();
        }).fail(function() {
            $("#chat-history-loading").remove();
        });
    }

    // Hàm hiển thị tin nhắn mới vào khung chat
    function appendOne(m) {
        let isUser = m.sender === "user";
        let senderClass = isUser ? "user" : "bot";
        let avatarEmoji = isUser ? "👤" : "🥬";

        let rawMessage = m.message;
        let formattedMessage = "";

        if (isUser) {
            // Đối với user, chỉ escape các ký tự đặc biệt để chống XSS và giữ nguyên văn bản thô
            formattedMessage = escapeHtml(rawMessage).replace(/\n/g, "<br>");
        } else {
            // Đối với bot, sử dụng marked.js để render Markdown sang HTML nếu thư viện hoạt động
            let fallbackFormat = () => escapeHtml(rawMessage)
                .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
                .replace(/\n/g, "<br>");

            if (typeof marked !== 'undefined') {
                try {
                    formattedMessage = marked.parse(rawMessage);
                } catch (err) {
                    console.error("[Chat] marked.parse() lỗi, dùng fallback text thô:", err, rawMessage);
                    formattedMessage = fallbackFormat();
                }
            } else {
                // Phương án dự phòng (fallback) nếu không có marked.js
                formattedMessage = fallbackFormat();
            }
        }

        let messageHtml = `
            <div class="message-wrapper ${senderClass}">
                <div class="msg-avatar">${avatarEmoji}</div>
                <div class="message-bubble">${formattedMessage}</div>
            </div>
        `;

        $("#chat-messages").append(messageHtml);
        scrollToBottom();
    }

    // Hiển thị Typing Indicator
    function showTypingIndicator() {
        // Xóa indicator cũ nếu có
        hideTypingIndicator();

        let typingHtml = `
            <div id="typing-indicator-wrapper" class="message-wrapper bot">
                <div class="msg-avatar">🥬</div>
                <div class="message-bubble">
                    <div class="typing-dots">
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                    </div>
                </div>
            </div>
        `;
        $("#chat-messages").append(typingHtml);
        scrollToBottom();
    }

    // Ẩn Typing Indicator
    function hideTypingIndicator() {
        $("#typing-indicator-wrapper").remove();
    }

    // Cuộn mượt xuống cuối khung chat
    function scrollToBottom() {
        let container = $("#chat-messages");
        if (container.length > 0) {
            container.scrollTop(container[0].scrollHeight);
        }
    }

    // Hàm escape HTML chống XSS
    function escapeHtml(text) {
        return $("<div/>").text(text).html();
    }
});
