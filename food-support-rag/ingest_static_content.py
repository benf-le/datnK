"""
Script nạp nội dung các trang web tĩnh của KFood (giới thiệu, liên hệ, FAQ,
chính sách giao hàng/đổi trả, thanh toán, dịch vụ...) vào Vector DB Qdrant.

Nội dung được trích xuất thủ công từ các file Blade tĩnh trong dự án Laravel:
  - resources/views/clients/pages/about.blade.php
  - resources/views/clients/pages/contact.blade.php
  - resources/views/clients/pages/faq.blade.php
  - resources/views/clients/pages/service.blade.php
  - resources/views/clients/partials/feature.blade.php
  - resources/views/clients/partials/footer.blade.php

Mỗi chủ đề được nạp thành 1 "tài liệu tri thức" riêng để giữ ngữ cảnh mạch lạc,
giúp AI truy vấn (Semantic Search) chính xác hơn.

Script gọi TRỰC TIẾP hàm async_ingest_document trong rag_service nên KHÔNG cần
FastAPI server phải đang chạy — chỉ cần file .env đã cấu hình OPENAI_API_KEY và
QDRANT_URL/QDRANT_API_KEY.

Cách dùng (từ thư mục food-support-rag, dùng python của venv):
    venv/Scripts/python.exe ingest_static_content.py      # Windows
    ./venv/bin/python ingest_static_content.py            # Linux/Mac
"""

import asyncio

from rag_service import async_ingest_document, async_delete_general_knowledge

# --- KHO TRI THỨC TĨNH: (Tiêu đề, Nội dung) ---
# Mỗi phần tử được nạp thành 1 tài liệu tri thức riêng biệt.
KNOWLEDGE_DOCS: list[tuple[str, str]] = [
    (
        "Giới thiệu về KFood",
        "KFood là cửa hàng thực phẩm sạch, chuyên cung cấp thực phẩm tươi ngon, an toàn "
        "và tốt cho sức khỏe cho mọi gia đình Việt. KFood tin rằng kinh doanh không chỉ là "
        "buôn bán mà còn là cách lan tỏa điều tốt lành, xây dựng một cộng đồng tin cậy nơi "
        "người bán và người mua cùng chia sẻ những sản phẩm chất lượng, an toàn và mang lại "
        "giá trị thật cho cuộc sống. Giám đốc cửa hàng là ông Hồ Quốc Khánh. "
        "KFood cam kết mang đến sản phẩm chất lượng cao, an toàn cùng dịch vụ chu đáo, tận tâm "
        "để khách hàng luôn an tâm khi lựa chọn."
    ),
    (
        "Thông tin liên hệ KFood",
        "Khách hàng có thể liên hệ KFood qua các kênh sau:\n"
        "- Số điện thoại (hotline): 0994 913 686.\n"
        "- Email: khanhhq.21ad@vku.udn.vn.\n"
        "- Địa chỉ / công ty: 67 Ngũ Hành Sơn, Đà Nẵng.\n"
        "- Bộ phận chăm sóc khách hàng hỗ trợ 24/7.\n"
        "Khách hàng cần hỗ trợ hoặc muốn nhận báo giá có thể gọi hotline, gửi email "
        "hoặc điền form liên hệ trên website KFood."
    ),
    (
        "Chính sách giao hàng KFood",
        "Phí giao hàng của KFood là hoàn toàn 25000đ trong khu vực nội thành. KFood sẽ "
        "giao hàng tận nhà trong thời gian nhanh nhất có thể sau khi khách xác nhận đơn hàng. "
        "Hiện KFood đã phục vụ hơn 15 tỉnh thành, giao thành công hơn 10.000 đơn hàng."
    ),
    (
        "Chính sách đổi trả và hoàn tiền KFood",
        "KFood chấp nhận đổi trả trong vòng 3 ngày kể từ khi nhận hàng nếu sản phẩm bị hư hỏng, "
        "giao sai loại hoặc không đạt chất lượng như cam kết. Tùy tình huống cụ thể, KFood sẽ "
        "hoàn tiền hoặc đổi sản phẩm mới cho khách hàng. Khi cần đổi trả hoặc hoàn tiền, khách hàng "
        "hãy liên hệ ngay bộ phận chăm sóc khách hàng qua hotline 0994 913 686 để được hỗ trợ "
        "nhanh nhất."
    ),
    (
        "Phương thức thanh toán KFood",
        "KFood hỗ trợ nhiều phương thức thanh toán linh hoạt: thẻ tín dụng, thẻ ghi nợ, "
        "ví điện tử và chuyển khoản ngân hàng. Tất cả giao dịch đều được mã hóa bảo mật "
        "để đảm bảo an toàn tuyệt đối cho khách hàng."
    ),
    (
        "Hướng dẫn đặt hàng cho khách mới tại KFood",
        "Cách đặt mua sản phẩm tại KFood rất đơn giản: khách hàng chọn sản phẩm mong muốn, "
        "thêm vào giỏ hàng và điền thông tin giao hàng. Sau khi xác nhận đơn, đội ngũ KFood sẽ "
        "liên hệ xác nhận và giao đến tận nhà nhanh nhất có thể. Với khách hàng mới, chỉ cần tạo "
        "tài khoản, đăng nhập và duyệt các sản phẩm tươi sạch, chọn sản phẩm yêu thích, thêm vào "
        "giỏ và đặt hàng – KFood sẽ lo phần còn lại."
    ),
    (
        "Chính sách bảo mật thông tin KFood",
        "KFood tuyệt đối bảo mật thông tin cá nhân của khách hàng. Mọi dữ liệu chỉ được sử dụng "
        "để phục vụ đơn hàng và chăm sóc sau bán hàng, không chia sẻ cho bất kỳ bên thứ ba nào."
    ),
    (
        "Chính sách mã giảm giá KFood",
        "Nếu mã giảm giá không sử dụng được, khách hàng hãy kiểm tra xem mã còn hạn sử dụng hay "
        "không, hoặc mã có áp dụng cho sản phẩm đang chọn không. Nếu vẫn không dùng được, hãy liên "
        "hệ bộ phận hỗ trợ để KFood giúp kích hoạt hoặc cấp mã giảm giá mới."
    ),
    (
        "Dịch vụ và danh mục sản phẩm KFood",
        "KFood cung cấp các dịch vụ chất lượng cho khách hàng bao gồm:\n"
        "- Trái cây tươi sạch: giàu dinh dưỡng, thu hoạch từ nông trại an toàn, đạt tiêu chuẩn chất lượng cao.\n"
        "- Thực phẩm tươi sống: cung cấp các loại thịt, cá, hải sản tươi sống chất lượng cao, có nguồn gốc rõ ràng và bảo quản an toàn.\n"
        "- Giao hàng tận nơi: giao hàng tận nhà nhanh chóng với phí 25.000đ trong khu vực nội thành sau khi khách xác nhận đơn hàng.\n"
        "Điểm mạnh dịch vụ của KFood: giao hàng tận nhà nhanh chóng với phí 25.000đ, đội ngũ chuyên môn tận tâm, "
        "thiết bị đảm bảo vệ sinh và cung cấp thực phẩm tươi sạch an toàn."
    ),
    (
        "Cam kết và lý do chọn KFood",
        "Lý do nên chọn KFood:\n"
        "- Thương hiệu đáng tin cậy: hợp tác với nhiều thương hiệu uy tín, mang đến nguồn thực phẩm sạch, chất lượng.\n"
        "- Sản phẩm tươi ngon chọn lọc: mỗi sản phẩm được chọn lựa cẩn thận, đảm bảo tươi mới, an toàn, giữ trọn hương vị tự nhiên.\n"
        "- Thực phẩm không hóa chất: nói không với thuốc trừ sâu và chất bảo quản, nguồn gốc rõ ràng.\n"
        "- Giao hàng tận nhà nhanh chóng, tiện lợi với phí 25.000đ trong nội thành.\n"
        "KFood tự hào với hơn 500 khách hàng hài lòng, hơn 10.000 đơn hàng giao thành công, "
        "100% thực phẩm tươi sạch và phục vụ hơn 15 tỉnh thành."
    ),
]


async def main() -> None:
    print("--- Dọn dẹp dữ liệu cũ ---")
    try:
        await async_delete_general_knowledge()
    except Exception as e:
        print(f"[CẢNH BÁO] Không thể xóa dữ liệu cũ: {e}")

    print(f"\n--- Bắt đầu nạp {len(KNOWLEDGE_DOCS)} tài liệu tĩnh vào Qdrant ---\n")

    success = 0
    for title, text in KNOWLEDGE_DOCS:
        full_text = f"{title}.\n{text}"
        try:
            chunks = await async_ingest_document(full_text)
            print(f"  [OK] '{title}' -> {chunks} chunks")
            success += 1
        except Exception as e:
            print(f"  [LỖI] '{title}': {e}")

    print(f"\n--- Hoàn tất: {success}/{len(KNOWLEDGE_DOCS)} tài liệu nạp thành công ---")


if __name__ == "__main__":
    asyncio.run(main())
