<!-- Floating Chat -->
<div id="chat-widget">
    <!-- Nút mở chat với hiệu ứng Pulse -->
    <div id="chat-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="28" height="28">
            <path fill-rule="evenodd"
                d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.58.232 2.848 1.547 2.848 3.183v5.093c0 1.636-1.268 2.951-2.848 3.183a48.653 48.653 0 01-1.92.215l-3.92 3.92a.75.75 0 01-1.28-.53v-3.238c-.378-.013-.75-.032-1.12-.056c-1.58-.104-2.714-1.425-2.714-3.023a47.581 47.581 0 00-6.152.52C3.268 12.28 2 13.595 2 15.23v5.093c0 1.636 1.268 2.951 2.848 3.183a49.144 49.144 0 011.92.215l3.92 3.92a.75.75 0 001.28-.53v-3.238c3.76-.13 7.283-.997 10.37-2.45a.75.75 0 10-.67-1.34c-2.822 1.41-6.046 2.2-9.45 2.2a47.64 47.64 0 01-1.92-.19l-2.47-2.47v1.41a.75.75 0 00-.75-.75h-.37c-1.176 0-2.09-.982-2.09-2.2v-5.093c0-1.218.914-2.2 2.09-2.2c2.016 0 3.996-.134 5.937-.393a.75.75 0 00.563-.736V6.75c0-1.218.914-2.2 2.09-2.2c2.148 0 4.267.158 6.348.463a.75.75 0 00.86-.736v-.37c0-1.176-.982-2.09-2.2-2.09a47.64 47.64 0 00-1.92-.19l-2.47-2.47v1.41a.75.75 0 01-1.5 0V1.75a.75.75 0 00-.75-.75h-.37c-1.176 0-2.09.982-2.09 2.2v5.093c0 1.218-.914 2.2-2.09 2.2a47.62 47.62 0 01-1.92-.19l-2.47-2.47v1.41a.75.75 0 00-1.5 0V1.75a.75.75 0 00-.75-.75h-.37c-1.176 0-2.09.982-2.09 2.2V6.75a.75.75 0 01-1.5 0V5.25c0-1.636 1.268-2.951 2.848-3.183z" />
        </svg>
    </div>

    <!-- Khung chat chính với phong cách Glassmorphism -->
    <div id="chat-box" class="hidden">
        <div id="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar-container">
                    <div class="chat-avatar">🥬</div>
                    <span class="chat-status-dot"></span>
                </div>
                <div class="chat-title-wrapper">
                    <span class="chat-title">Trợ lý KFood</span>
                    <span class="chat-subtitle">Online • Sẵn sàng hỗ trợ</span>
                </div>
            </div>
            <div class="chat-header-actions">
                <button type="button" id="chat-close" title="Đóng chat">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"
                        height="20">
                        <path
                             d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Vùng hiển thị tin nhắn -->
        <div id="chat-messages">
            <!-- Tin nhắn mẫu sẽ được nạp qua JS -->
        </div>

        <!-- Khung gõ tin nhắn và gợi ý nhanh -->
        <div id="chat-footer">
            <!-- Nút gợi ý nhanh (Quick Replies) -->
            <div id="chat-quick-replies">
                <button type="button" class="quick-reply-btn" data-reply="Bắt đầu lại">🔄 Bắt đầu lại</button>
                <button type="button" class="quick-reply-btn" data-reply="Cửa hàng có những danh mục sản phẩm nào?">🗂️ Sản
                    phẩm</button>
                <button type="button" class="quick-reply-btn" data-reply="Phí giao hàng tính thế nào?">🛵 Phí giao hàng</button>
                <button type="button" class="quick-reply-btn" data-reply="Cách thức liên hệ trực tiếp?">📞 Liên hệ</button>
            </div>

            <!-- Ô nhập nội dung -->
            <div id="chat-input-container">
                <input type="text" id="message-input" placeholder="Nhập tin nhắn của bạn..." autocomplete="off">
                <button id="send-btn" title="Gửi tin nhắn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20"
                        height="20">
                        <path
                            d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Load thư viện marked.js CDN để hỗ trợ parse Markdown sang HTML sạch đẹp -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>