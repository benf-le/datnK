# Hướng dẫn chạy Dự án với Docker Compose

Tài liệu này hướng dẫn cách chạy song song hai dự án **food-ecommerce** (Laravel) và **food-support-rag** (Python/FastAPI RAG) bằng Docker Compose.

---

## 🏗️ Kiến trúc Docker
Hệ thống sử dụng file `docker-compose.yml` ở thư mục gốc để điều phối 3 containers chính:
1. **`rag-service`** (`fastapi_rag_app`): API RAG xử lý các truy vấn thông minh và giao tiếp cơ sở dữ liệu Vector (Qdrant). Chạy tại cổng `8000`.
2. **`laravel-app`** (`laravel_web_app`): Máy chủ web Laravel (PHP 8.2 + Apache). Chạy tại cổng `8001`.
3. **`laravel-worker`** (`laravel_queue_worker`): Chạy hàng đợi (`php artisan queue:work`) để đồng bộ dữ liệu sản phẩm sang RAG Service trong thời gian thực.

---

## ⚡ Các bước chuẩn bị và khởi chạy

> [!IMPORTANT]
> Cả 2 dự án đều sử dụng dịch vụ Cloud (Database Neon PGSQL & Vector DB Qdrant Cloud), hãy đảm bảo máy tính của bạn đang **kết nối mạng** ổn định trước khi build Docker.

### Bước 1: Kiểm tra cấu hình môi trường (.env)
* **`food-support-rag/.env`**: Chứa thông tin cấu hình cho OpenAI API Key và Qdrant Cloud URL.
* **`food-ecommerce/.env`**: Chứa liên kết tới database PostgreSQL (Neon).
  > **Lưu ý:** Bạn không cần sửa đổi file `.env` thủ công. Docker Compose đã tự động thiết lập để Laravel gọi đến `rag-service` qua tên dịch vụ nội bộ `http://rag-service:8000` mà không ảnh hưởng tới cấu hình chạy local ngoài Docker (`http://127.0.0.1:8000`).

### Bước 2: Build và Khởi chạy ứng dụng
Mở Terminal tại thư mục gốc (`e:\datnK`) và chạy lệnh sau:

```bash
# Khởi chạy Docker Compose và build lại các images nếu cần
docker compose up --build
```

Nếu muốn chạy dưới dạng background (chạy ngầm), thêm cờ `-d`:
```bash
docker compose up -d --build
```

### Bước 3: Truy cập ứng dụng
Sau khi khởi chạy thành công:
* **Laravel Web App:** [http://localhost:8001](http://localhost:8001)
* **FastAPI RAG Service:** [http://localhost:8000](http://localhost:8000)
* **FastAPI Docs (Swagger UI):** [http://localhost:8000/docs](http://localhost:8000/docs)

---

## 🛠️ Một số lệnh Docker hữu ích

### 1. Xem trạng thái các container
```bash
docker compose ps
```

### 2. Xem Logs thời gian thực
* Xem toàn bộ logs:
  ```bash
  docker compose logs -f
  ```
* Chỉ xem logs của Laravel Web:
  ```bash
  docker compose logs -f laravel-app
  ```
* Chỉ xem logs của RAG Service:
  ```bash
  docker compose logs -f rag-service
  ```

### 3. Khởi động lại hoặc dừng dịch vụ
* Dừng các dịch vụ và giữ nguyên dữ liệu:
  ```bash
  docker compose down
  ```
* Dừng dịch vụ và xóa hoàn toàn volume (khi muốn dọn dẹp bộ nhớ cache dependencies):
  ```bash
  docker compose down -v
  ```

### 4. Truy cập Terminal bên trong Container
Nếu bạn cần chạy lệnh thủ công như seeding dữ liệu, xóa cache trong container Laravel:
```bash
docker compose exec laravel-app bash
```
Sau đó bạn có thể chạy các lệnh artisan bình thường, ví dụ:
```bash
php artisan db:seed
php artisan rag:sync-products
```

---

## 💡 Cơ chế tối ưu hóa hiệu năng trong Docker Compose
1. **Isolated Named Volumes:** Thư mục `vendor/` và `node_modules/` của Laravel được cô lập trong Docker volumes (`laravel-vendor` và `laravel-node-modules`). Điều này giúp tránh xung đột file nhị phân giữa Windows và Linux, đồng thời tăng tốc độ I/O.
2. **Auto-Install & Compile:** Container Laravel tự động kiểm tra xem `vendor` hoặc `node_modules` có tồn tại chưa. Nếu chưa, nó tự động chạy `composer install`, `npm install` và `npm run build` để dựng giao diện.
3. **Atomic Migrations:** Migration chỉ chạy một lần từ container chính `laravel-app` để tránh xung đột tài nguyên với container worker.
