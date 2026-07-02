# Food E-Commerce Website (Laravel 12 + Tailwind CSS + PostgreSQL)

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.2-blue.svg?style=flat-square&logo=php)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL-blue?style=flat-square&logo=postgresql)](https://www.postgresql.org/)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF.svg?style=flat-square&logo=vite)](https://vite.dev)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-38B2AC.svg?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)

Đây là dự án website thương mại điện tử bán đồ ăn (Food E-Commerce) được xây dựng trên nền tảng **Laravel 12** kết hợp với **Tailwind CSS**, hệ quản trị cơ sở dữ liệu **PostgreSQL**, tích hợp thanh toán qua **PayPal** và chatbot AI hỗ trợ khách hàng qua **Google Gemini API**.

---

## 🚀 Các Tính Năng Chính

### 🛍️ Client Side (Trang Khách Hàng)
*   **Trang chủ (Home):** Hiển thị banner slider, sản phẩm nổi bật, sản phẩm mới, danh mục sản phẩm.
*   **Danh sách sản phẩm (Shop/Products):** Lọc sản phẩm theo danh mục, khoảng giá, sắp xếp và tìm kiếm thông minh.
*   **Chi tiết sản phẩm (Product Detail):** Đánh giá sản phẩm (Reviews), sản phẩm liên quan, thêm vào giỏ hàng/yêu thích.
*   **Giỏ hàng (Cart):** Thêm nhanh (Mini Cart), cập nhật số lượng, xóa sản phẩm trực tiếp.
*   **Yêu thích (Wishlist):** Lưu trữ sản phẩm yêu thích của khách hàng.
*   **Thanh toán (Checkout):** 
    *   Hỗ trợ quản lý nhiều địa chỉ giao hàng (sổ địa chỉ).
    *   Thanh toán khi nhận hàng (COD).
    *   Thanh toán online bảo mật qua **PayPal Sandbox**.
*   **Quản lý tài khoản (My Account):** Cập nhật thông tin cá nhân, thay đổi mật khẩu, lịch sử đơn hàng và trạng thái đơn hàng (Hủy đơn, Đã nhận hàng).
*   **AI Chatbot:** Hỗ trợ tư vấn món ăn trực tuyến tích hợp **Google Gemini API**.
*   **Liên hệ (Contact):** Gửi phản hồi, thắc mắc tới ban quản trị.

### 🛡️ Admin Side (Trang Quản Trị - `/admin`)
*   **Báo cáo thống kê (Dashboard):** Biểu đồ doanh thu, số lượng đơn hàng, người dùng mới.
*   **Quản lý người dùng (Users):** Xem danh sách thành viên, nâng cấp quyền (Admin/Staff), thay đổi trạng thái hoạt động.
*   **Quản lý danh mục (Categories):** Thêm, sửa, xóa danh mục món ăn.
*   **Quản lý sản phẩm (Products):** Quản lý thông tin, giá bán, mô tả, hình ảnh món ăn.
*   **Quản lý đơn hàng (Orders):** Xác nhận đơn hàng, xem chi tiết, gửi hóa đơn (Invoice) qua Email cho khách hàng, hủy đơn hàng.
*   **Quản lý liên hệ (Contacts):** Xem và phản hồi trực tiếp các thắc mắc từ khách hàng qua email.
*   **Thông báo (Notifications):** Hệ thống nhận thông báo tức thời khi có hoạt động mới.

---

## 🛠️ Yêu Cầu Hệ Thống

Để chạy được dự án này, máy tính của bạn cần cài đặt sẵn:
*   **PHP** >= 8.2 (yêu cầu cài đặt các extension: `pdo_pgsql`, `pgsql`, `openssl`, `mbstring`, `xml`, `gd` hoặc `imagick`)
*   **Composer** (Trình quản lý thư viện PHP)
*   **Node.js** (đã bao gồm `npm`)
*   **PostgreSQL** (Hệ quản trị cơ sở dữ liệu)

---

## 💻 Hướng Dẫn Cài Đặt Chi Tiết

Làm theo các bước sau để thiết lập dự án trên máy local:

### Bước 1: Sao chép thư mục dự án
Mở terminal tại thư mục bạn muốn lưu dự án và thực hiện:
```bash
git clone <repository_url>
cd food-ecommerce
```

### Bước 2: Cài đặt các thư viện PHP (Composer)
```bash
composer install
```

### Bước 3: Cài đặt các thư viện Front-end (NPM)
```bash
npm install
```

### Bước 4: Thiết lập file môi trường `.env`
Sao chép file `.env.example` thành `.env`:
```bash
cp .env.example .env
```
Mở file `.env` lên và cấu hình các thông số sau:
1.  **Cấu hình Database (PostgreSQL):**
    ```env
    DB_CONNECTION=pgsql
    DB_URL=postgresql://username:password@127.0.0.1:5432/your_database_name?sslmode=prefer
    ```
    *(Hoặc bạn có thể tách ra thành `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` tùy thuộc vào cấu hình môi trường của bạn)*

2.  **Cấu hình gửi mail (SMTP) - Để gửi hóa đơn/liên hệ:**
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your_gmail@gmail.com
    MAIL_PASSWORD=your_app_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="your_gmail@gmail.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

3.  **Cấu hình PayPal Sandbox (Nếu cần test thanh toán online):**
    ```env
    PAYPAL_MODE=sandbox
    PAYPAL_CLIENT_ID=your_paypal_client_id
    PAYPAL_CLIENT_SECRET=your_paypal_client_secret
    ```

4.  **Cấu hình Google Gemini AI Key (Nếu cần dùng Chatbot):**
    ```env
    GOOGLE_GEMINI_API_KEY=your_gemini_api_key
    ```

### Bước 5: Khởi tạo Application Key
```bash
php artisan key:generate
```

### Bước 6: Chạy Migrations và Seeders (Khởi tạo Database & Dữ liệu mẫu)
Đảm bảo bạn đã tạo sẵn database trong PostgreSQL trước khi chạy lệnh này:
```bash
php artisan migrate --seed
```
*Lưu ý: Lệnh này sẽ chạy tất cả các bảng dữ liệu cần thiết và tạo sẵn dữ liệu mẫu (Tài khoản thử nghiệm, danh mục, quyền hạn).*

### Bước 7: Tạo liên kết thư mục Storage
Để hiển thị được các hình ảnh upload từ admin, bạn cần chạy:
```bash
php artisan storage:link
```

---

## 🏃 Hướng Dẫn Chạy Dự Án

Dự án sử dụng Laravel 12 tích hợp Vite, có 2 cách để chạy:

### Cách 1: Sử dụng lệnh Concurrently tích hợp sẵn (Khuyên dùng)
Dự án đã được thiết lập script chạy đồng thời cả Server Laravel, Hàng đợi Queue và Vite. Bạn chỉ cần chạy duy nhất 1 lệnh:
```bash
composer dev
```
Lệnh này sẽ tự động khởi động:
*   Laravel Server tại: `http://127.0.0.1:8001`
*   Vite Server (Biên dịch asset CSS/JS nhanh)
*   Queue Listener (Xử lý tác vụ gửi mail ngầm)
*   Laravel Pail (Xem log trực tiếp)

---

### Cách 2: Chạy các server riêng biệt
Nếu không sử dụng lệnh gộp trên, bạn cần mở 2 cửa sổ terminal riêng biệt:

1.  **Terminal 1:** Chạy Laravel Server:
    ```bash
    php artisan serve
    ```
2.  **Terminal 2:** Chạy Vite để biên dịch tài nguyên:
    ```bash
    npm run dev
    ```

Truy cập website tại: `http://127.0.0.1:8001`  
Truy cập trang quản trị tại: `http://127.0.0.1:8001/admin`

---

## 🔑 Tài Khoản Thử Nghiệm (Default Credentials)

Sau khi chạy xong lệnh `--seed`, hệ thống sẽ tự động tạo các tài khoản sau để bạn test:

| Vai Trò | Email Đăng Nhập | Mật Khẩu | Quyền Hạn |
| :--- | :--- | :--- | :--- |
| **Quản trị viên (Admin)** | `admin@example.com` | `123456` | Toàn quyền hệ thống, quản lý User, Product, Category, Order, v.v. |
| **Nhân viên (Staff)** | `staff@example.com` | `123456` | Quản lý sản phẩm, đơn hàng, phản hồi liên hệ. |
| **Khách hàng (Customer)** | `hoquockhanh@example.com` | `123456` | Xem sản phẩm, đặt hàng, thanh toán qua PayPal, Chat AI. |
| **Khách hàng (Customer)** | `nguyenvana@example.com` | `123456` | Tài khoản khách hàng phụ. |

---

## 📂 Cấu Trúc Thư Mục Quan Trọng

*   `app/Http/Controllers/` - Chứa logic xử lý của Client và Admin.
*   `routes/web.php` - Chứa định tuyến (routes) cho phía Client.
*   `routes/admin.php` - Chứa định tuyến (routes) cho trang quản trị Admin.
*   `resources/views/` - Giao diện Blade Templates (chia làm thư mục `clients` và `admin`).
*   `database/seeders/` - Chứa các file seeder khởi tạo dữ liệu mặc định.

---

## ⚡ Tối Ưu Hóa Hiệu Năng Đã Triển Khai (Performance Optimizations)

Để giải quyết tình trạng source code chạy chậm và trang web tải lâu, các giải pháp tối ưu hóa sau đã được áp dụng trực tiếp vào mã nguồn:

### 1. Khắc phục triệt để lỗi N+1 Database Query
*   **Vấn đề cũ:** Model `Product` có thuộc tính `$appends` tự động tính `image_url` và `average_rating`. Khi danh sách sản phẩm hiển thị trên trang chủ hoặc trang danh mục không được nạp trước (eager load) các mối quan hệ `firstImage` và `reviews`, Laravel sẽ thực hiện hàng chục truy vấn SQL riêng lẻ để lấy dữ liệu cho từng sản phẩm.
*   **Giải pháp đã triển khai:**
    *   Tại `HomeController.php` và `ProductController.php`, đã nâng cấp truy vấn thành `Product::with(['firstImage', 'reviews'])` hoặc `Category::with(['products.firstImage', 'products.reviews'])`.
    *   Tại trang quản trị Admin (`DashboardController.php`), thay vì nạp tất cả các model sản phẩm chỉ để đếm số lượng, hệ thống đã chuyển sang dùng `Category::withCount('products')` để đếm trực tiếp từ Database qua truy vấn SQL đơn, giúp giảm tải đáng kể bộ nhớ.

### 2. Tách PayPal SDK khỏi trang chủ và các trang không liên quan
*   **Vấn đề cũ:** Script PayPal SDK nặng được nhúng trực tiếp trong file layout chính (`client.blade.php`, `client_home.blade.php`), làm tăng thời gian chặn hiển thị (render-blocking) trên mọi trang con.
*   **Giải pháp đã triển khai:**
    *   Đã gỡ bỏ script PayPal khỏi layout dùng chung.
    *   PayPal SDK chỉ được tải duy nhất tại trang Thanh toán (`checkout.blade.php`) bằng cách sử dụng cấu trúc `@section('scripts')`.
    *   Trong `custom.js`, bổ sung khối kiểm tra `if (typeof paypal !== "undefined")` để đảm bảo code JavaScript không bị lỗi ReferenceError khi chạy ở các trang khác.

### 3. Xử lý API Python Gợi ý Sản phẩm (Product Recommendation)
*   **Vấn đề cũ:** Tại trang chi tiết sản phẩm, Laravel thực hiện gọi API gợi ý (`http://127.0.0.1:5555/api/product-recommendation`) đồng bộ. Nếu cổng `5555` không chạy hoặc server Python bị lỗi/quá tải, PHP sẽ bị treo trong 30 giây, khiến người dùng không thể xem được trang chi tiết sản phẩm.
*   **Giải pháp đã triển khai:**
    *   Bổ sung cơ chế Timeout: `Http::timeout(1.5)->connectTimeout(1.0)->get(...)` vào yêu cầu gọi API Python. 
    *   Nếu server Python offline hoặc phản hồi quá 1.5 giây, Laravel sẽ tự động bắt lỗi (Catch), bỏ qua gợi ý và hiển thị sản phẩm liên quan mặc định từ database thay vì chặn hiển thị toàn bộ trang.

---

## 🐍 Cách Chạy Hệ Thống Gợi Ý Sản Phẩm (Python Recommendation System)

Hệ thống gợi ý sản phẩm chạy độc lập trên máy chủ Python (mặc định tại cổng `5555`).

### 1. Chuẩn bị môi trường Python
Yêu cầu máy cài đặt sẵn **Python 3.x**. Mở terminal tại thư mục chứa source Python (nếu có) hoặc cài đặt các thư viện cần thiết:
```bash
pip install flask pandas scikit-learn gunicorn
```

### 2. Khởi chạy Server gợi ý sản phẩm
Khởi chạy file server Python (ví dụ: `app.py` hoặc `recommend.py` của bạn) tại cổng `5555`:
```bash
# Lệnh chạy phát triển (Local)
python app.py
```
*(Nếu sử dụng Flask hoặc framework khác, hãy đảm bảo API endpoint lắng nghe tại: `http://127.0.0.1:5555/api/product-recommendation?product_id=<id>` và trả về định dạng JSON chứa danh sách `related_products` dạng mảng ID sản phẩm)*

---

## 🚀 Tối Ưu Hóa Cho Môi Trường Production

Khi triển khai trang web lên máy chủ chạy thực tế (Production), hãy chạy các lệnh sau để cải thiện tốc độ phản hồi của Laravel gấp nhiều lần:

### 1. Bật bộ nhớ đệm cấu hình và định tuyến
```bash
# Cache cấu hình .env và config/*.php
php artisan config:cache

# Cache danh sách routes
php artisan route:cache

# Cache các file view Blade đã được biên dịch
php artisan view:cache
```

### 2. Biên dịch nén Asset tĩnh qua Vite
Tránh tải các file CSS/JS riêng lẻ từ thư mục public. Hãy chạy lệnh build để Vite đóng gói, nén dung lượng tối đa:
```bash
npm run build
```

### 3. Tối ưu hóa PHP Autoloader của Composer
```bash
composer install --optimize-autoloader --no-dev
```