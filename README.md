# 🍕 Hệ Thống Bán Lẻ Thức Ăn Thông Minh (Food Retail Platform)

Một nền tảng bán lẻ thức ăn **hiện đại, thông minh và mạnh mẽ** cho cửa hàng bán đồ ăn trực tuyến, được xây dựng từ **hai hệ thống độc lập nhưng liên kết chặt chẽ**:

1. 🛒 **Hệ Thống Bán Hàng** (Laravel 12 + Tailwind CSS)
2. 🤖 **Hệ Thống Hỗ Trợ AI** (FastAPI + RAG + Chatwoot)

---

## 📋 Tổng Quan Dự Án

### 🎯 Mục Đích

Cung cấp một **nền tảng bán lẻ thức ăn trực tuyến hoàn chỉnh** với:
- ✅ Quản lý kho hàng và sản phẩm thức ăn đa dạng
- ✅ Hệ thống thanh toán trực tuyến an toàn (PayPal)
- ✅ Giao diện khách hàng thân thiện và responsive
- ✅ Dashboard quản lý cửa hàng & doanh số toàn diện
- ✅ **AI Chatbot tư vấn & hỗ trợ khách hàng 24/7** dựa trên RAG
- ✅ Đồng bộ dữ liệu sản phẩm sang Vector Database để AI tư vấn chính xác

### 🏗️ Kiến Trúc Hệ Thống

```
┌─────────────────────────────────────────────────────────────┐
│           KH TRỰC TUYẾN / ADMIN DASHBOARD                   │
└────────────┬──────────────────────────────────┬─────────────┘
             │                                  │
      ┌──────▼───────────┐            ┌──────▼────────────┐
      │  Cửa hàng       │            │   Chatbot Widget   │
      │  Trực tuyến      │            │  (Tư vấn AI)      │
      │  (Port 8001)    │            │  (Embedded)       │
      └──────┬──────────┘            └──────┬────────────┘
             │                              │
             │ API Request                  │ Webhook
             │                              │
      ┌──────▼──────────────────────────────▼───────────┐
      │    Hệ Thống AI Hỗ Trợ (Port 8000)              │
      │  ┌──────────┐  ┌──────────┐  ┌──────────────┐  │
      │  │  OpenAI  │  │  Qdrant  │  │  Chatwoot    │  │
      │  │ Embedding   Vector DB   │  │  API Client  │  │
      │  └──────────┘  └──────────┘  └──────────────┘  │
      └────────────────────────────────────────────────┘
             │
      ┌──────▼──────────────┐
      │   PostgreSQL        │
      │   (Cloud Neon)      │
      └─────────────────────┘
```

---

## 📁 Cấu Trúc Thư Mục

```
datnK/
├── food-ecommerce/          # 🛒 Hệ Thống Bán Hàng Chính
│   ├── app/                 # Logic xử lý (Controllers, Models, Business Logic)
│   ├── resources/views/     # Giao diện Blade (Web + Admin Dashboard)
│   ├── routes/              # web.php (storefront), admin.php (quản lý)
│   ├── database/            # Migrations, Seeders, Schema
│   ├── public/              # Assets tĩnh (CSS, JS, hình ảnh)
│   ├── .env.example         # File cấu hình mẫu
│   └── Dockerfile           # Container config
│
├── food-support-rag/        # 🤖 Hệ Thống AI Hỗ Trợ Khách Hàng
│   ├── main.py              # FastAPI Router chính
│   ├── rag_service.py       # Engine RAG (Embedding, Vector Search)
│   ├── chatwoot_service.py  # Tích hợp Chatwoot API
│   ├── .env.example         # File cấu hình mẫu
│   ├── requirements.txt      # Python dependencies
│   ├── Dockerfile           # Container config
│   └── docker-compose.yml   # Tùy chọn: Chạy Qdrant local
│
├── docker-compose.yml       # 🐳 Chạy cả 2 hệ thống cùng lúc
├── DOCKER_GUIDE.md          # Hướng dẫn chi tiết Docker Compose
└── README.md                # File này
```

---

## 🚀 Quick Start (Khởi Động Nhanh)

### Cách 1: Chạy Bằng Docker Compose (Khuyến Nghị) ⭐

Đây là cách **nhanh nhất** và **yêu cầu tối thiểu**:

```bash
# Bước 1: Chuẩn bị file .env cho cả 2 dự án
cp food-ecommerce/.env.example food-ecommerce/.env
cp food-support-rag/.env.example food-support-rag/.env

# Bước 2: Mở .env và điền API Key, Database URL, Chatwoot settings
# (Xem chi tiết tại DOCKER_GUIDE.md)

# Bước 3: Khởi chạy Docker
docker compose up -d --build

# Bước 4: Chạy migrations & seed dữ liệu
docker compose exec laravel-app php artisan migrate --seed

# Bước 5: Truy cập ứng dụng
# - Website: http://localhost:8001
# - Admin: http://localhost:8001/admin
# - RAG API: http://localhost:8000/docs
```

📚 Xem chi tiết: [DOCKER_GUIDE.md](./DOCKER_GUIDE.md)

---

### Cách 2: Chạy Cục Bộ Trên Máy (Local Development)

#### 🛒 Khởi Động Hệ Thống Bán Hàng (Laravel)

```bash
cd food-ecommerce

# Cài đặt dependencies PHP & JavaScript
composer install
npm install

# Cấu hình môi trường & khóa ứng dụng
cp .env.example .env
php artisan key:generate

# Khởi tạo database & dữ liệu mẫu
php artisan migrate --seed

# Tạo liên kết lưu trữ hình ảnh sản phẩm
php artisan storage:link

# Chạy server (mở 1 terminal duy nhất)
composer dev
# HOẶC chạy riêng biệt:
php artisan serve      # Terminal 1
npm run dev            # Terminal 2
```

📚 Chi tiết: [food-ecommerce/README.md](./food-ecommerce/README.md)

---

#### 🤖 Khởi Động Food Support RAG (Python/FastAPI)

```bash
cd food-support-rag

# Tạo môi trường ảo Python
python -m venv venv

# Kích hoạt môi trường (Windows)
.\venv\Scripts\activate
# Hoặc macOS/Linux
source venv/bin/activate

# Cài đặt dependencies
pip install -r requirements.txt

# Cấu hình môi trường
cp .env.example .env
# Mở .env và điền OpenAI API Key, Qdrant URL, Chatwoot Token

# Chạy server FastAPI
python main.py

# API sẽ chạy tại: http://localhost:8000
# Swagger UI: http://localhost:8000/docs
```

📚 Chi tiết: [food-support-rag/README.md](./food-support-rag/README.md)

---

## 🔑 Tài Khoản Thử Nghiệm

Sau khi chạy `--seed`, các tài khoản mặc định sau sẽ được tạo:

| Vai Trò | Email | Mật Khẩu |
|---------|-------|----------|
| **Admin** | `admin@example.com` | `123456` |
| **Staff** | `staff@example.com` | `123456` |
| **Customer** | `hoquockhanh@example.com` | `123456` |
| **Customer** | `nguyenvana@example.com` | `123456` |

---

## ⚙️ Yêu Cầu Hệ Thống

### Để chạy Local (không dùng Docker):

#### Frontend E-Commerce:
- **PHP** >= 8.2 (+ extensions: `pdo_pgsql`, `openssl`, `mbstring`, `gd`)
- **Composer** (PHP dependency manager)
- **Node.js** 16+ (+ npm)
- **PostgreSQL** 12+ (hoặc sử dụng Cloud như Neon)

#### Backend RAG:
- **Python** 3.9+
- **pip** (Python package manager)

### Để chạy qua Docker:
- **Docker** 20.10+
- **Docker Compose** 1.29+
- **Kết nối mạng** ổn định (vì sử dụng Cloud services)

---

## 🌟 Các Tính Năng Chính

### 👤 Phía Khách Hàng (Client)

| Tính Năng | Mô Tả |
|-----------|-------|
| 🏪 Trang Chủ | Banner khuyến mãi, sản phẩm hot, danh mục món ăn |
| 🔍 Tìm Kiếm & Lọc | Tìm theo tên, lọc danh mục, khoảng giá, sắp xếp |
| 📄 Chi Tiết Sản Phẩm | Ảnh đủ góc độ, mô tả chi tiết, đánh giá, hàng liên quan |
| 🛒 Giỏ Hàng | Mini cart, cập nhật số lượng, xóa, tính tiền |
| ❤️ Danh Sách Yêu Thích | Lưu sản phẩm để mua sau |
| 💳 Thanh Toán | Cod (Tiền mặt), PayPal online an toàn |
| 📍 Địa Chỉ Giao Hàng | Quản lý & chọn từ nhiều địa chỉ |
| 👤 Quản Lý Tài Khoản | Đổi mật khẩu, lịch sử mua hàng, theo dõi đơn |
| 🤖 **AI Chatbot Tư Vấn** | Gợi ý món ăn phù hợp dựa trên RAG |
| 📧 Liên Hệ & Phản Hồi | Gửi góp ý trực tiếp tới cửa hàng |

### 🛡️ Phía Quản Trị (Admin)

| Tính Năng | Mô Tả |
|-----------|-------|
| 📊 Bảng Điều Khiển | Doanh số, số đơn hàng, khách mới, trending |
| 👥 Quản Lý Nhân Viên | Tạo tài khoản, nâng cấp quyền (Admin/Staff) |
| 📦 Quản Lý Danh Mục | Thêm/sửa/xóa danh mục thức ăn |
| 🍕 Quản Lý Kho Hàng | Quản lý giá, kho tồn, mô tả, ảnh, xuất xứ |
| 📋 Quản Lý Đơn Hàng | Duyệt, xác nhận, gửi hóa đơn, xử lý hủy |
| 💬 Quản Lý Liên Hệ | Xem & phản hồi phản hồi từ khách hàng |
| 🔔 Thông Báo Hệ Thống | Nhận cảnh báo đơn hàng mới, stock còn lại |

---

## 🧠 Hệ Thống AI Tư Vấn Thức Ăn (RAG)

### Luồng Hoạt Động:

1. **Khách hàng hỏi**: "Tôi muốn ăn cái gì tốt cho sức khỏe?"
2. **Chatbot nhận câu hỏi** qua Chatwoot Widget
3. **Hệ Thống AI Xử Lý**:
   - Chuyển câu hỏi thành Vector (Embedding) 3072 chiều
   - Tìm kiếm thông tin sản phẩm liên quan trong Qdrant
   - Ghép thông tin sản phẩm + câu hỏi thành prompt đầy đủ
   - Gọi GPT-4o-mini để tạo lời tư vấn cá nhân hóa
4. **Gửi Lại Đáp Án**: Lời tư vấn được gửi về Chatbot

### Lợi Ích:
- ✅ **Tư vấn Chính Xác**: Dựa trên dữ liệu sản phẩm thực tế (không bịa)
- ✅ **Đa Ngôn Ngữ**: Hỗ trợ Tiếng Việt, Tiếng Anh
- ✅ **Tự Động 24/7**: Không cần nhân viên can thiệp

📚 Chi tiết: [food-support-rag/README.md](./food-support-rag/README.md)

---

## 🔒 Bảo Mật & Hiệu Năng

### Các Biện Pháp Bảo Mật:
- 🔐 **Password Hash**: Sử dụng bcrypt (Laravel)
- 🛡️ **CSRF Protection**: Token bảo vệ form submissions
- 🔑 **API Keys**: OpenAI, Qdrant, Chatwoot không lưu trong mã
- 📧 **Email Verification**: Xác thực email khi đăng ký
- 💳 **PayPal Sandbox**: Thanh toán an toàn qua PayPal

### Tối Ưu Hiệu Năng:
- ⚡ **Eager Loading**: Khắc phục N+1 query problem
- 🗂️ **Database Caching**: Cache truy vấn thường xuyên
- 📦 **Asset Minification**: CSS/JS được nén qua Vite
- 🚀 **Async Processing**: Queue jobs để gửi mail ngầm
- 🔄 **Production Optimization**: Config caching & route caching

📚 Chi tiết: [food-ecommerce/README.md](./food-ecommerce/README.md)

---

## 🧪 Kiểm Thử API

### 1. Kiểm Tra Trạng Thái RAG Service

```bash
curl http://localhost:8000/health
```

**Response**:
```json
{
  "status": "healthy",
  "openai_api": "configured",
  "chatwoot_api": "configured",
  "qdrant": "connected"
}
```

### 2. Nạp Tài Liệu Tri Thức

```bash
curl -X POST http://localhost:8000/ingest \
  -H "Content-Type: application/json" \
  -d '{
    "text": "Cửa hàng mở cửa từ 9:00 AM đến 10:00 PM mỗi ngày"
  }'
```

### 3. Giả Lập Webhook Chatwoot

```bash
curl -X POST http://localhost:8000/chatwoot/webhook \
  -H "Content-Type: application/json" \
  -d '{
    "event": "message_created",
    "message_type": "incoming",
    "content": "Tôi muốn gọi món gì tốt cho sức khỏe?",
    "conversation": {"id": 123},
    "account": {"id": 1}
  }'
```

---

## 📖 Tài Liệu Chi Tiết

| Tài Liệu | Nội Dung |
|----------|---------|
| 📘 [DOCKER_GUIDE.md](./DOCKER_GUIDE.md) | Hướng dẫn chạy Docker Compose cho cả 2 hệ thống |
| 🛒 [food-ecommerce/README.md](./food-ecommerce/README.md) | Setup & tính năng hệ thống bán hàng |
| 🤖 [food-support-rag/README.md](./food-support-rag/README.md) | Setup & hệ thống AI hỗ trợ khách |
| 📋 [food-ecommerce/implementation_plan.md](./food-ecommerce/implementation_plan.md) | Chi tiết kỹ thuật & roadmap |
| 🧠 [food-support-rag/implementation_plan.md](./food-support-rag/implementation_plan.md) | Chi tiết RAG engine & tích hợp |

---

## ❓ Troubleshooting (Giải Quyết Vấn Đề)

### Docker không chạy được?
1. Kiểm tra Docker installed: `docker --version`
2. Kiểm tra Docker running: `docker ps`
3. Xem logs: `docker compose logs -f`

### Lỗi kết nối database?
1. Kiểm tra `.env` có URL database đúng
2. Kiểm tra database online có tồn tại
3. Kiểm tra connection string: `DB_URL=postgresql://user:pass@host:5432/db`

### API RAG không hoạt động?
1. Kiểm tra OpenAI API Key trong `.env`
2. Kiểm tra Qdrant URL & API Key
3. Xem logs: `docker compose logs -f rag-service`

### Không nhận webhook Chatwoot?
1. Kiểm tra URL webhook trong Chatwoot settings
2. Kiểm tra Chatwoot token có hợp lệ
3. Xem logs: `docker compose logs -f laravel-app`

---

## 📞 Liên Hệ & Hỗ Trợ

Nếu gặp bất kỳ vấn đề nào:
- 📧 Gửi email tới: `homemada.claude.01@kyanon.digital`
- 🐛 Báo lỗi: Tạo issue trong repository
- 💬 Thảo luận: Hỗ trợ qua các kênh liên lạc khác

---

## 📄 License

Dự án này được phát triển cho mục đích giáo dục và thương mại. Mọi quyền lợi được bảo lưu.

---

## 🎓 Công Nghệ Sử Dụng

### Backend Hệ Thống Bán Hàng:
- ![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
- ![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
- ![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14+-blue?style=flat-square&logo=postgresql)

### Frontend Giao Diện Storefront:
- ![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-38B2AC?style=flat-square&logo=tailwindcss)
- ![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=flat-square&logo=vite)
- ![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-yellow?style=flat-square&logo=javascript)

### AI & RAG:
- ![FastAPI](https://img.shields.io/badge/FastAPI-Latest-009688?style=flat-square&logo=fastapi)
- ![Python](https://img.shields.io/badge/Python-3.9+-blue?style=flat-square&logo=python)
- ![OpenAI](https://img.shields.io/badge/OpenAI-API-green?style=flat-square&logo=openai)
- ![Qdrant](https://img.shields.io/badge/Qdrant-VectorDB-purple?style=flat-square)

### Infrastructure:
- ![Docker](https://img.shields.io/badge/Docker-Latest-2496ED?style=flat-square&logo=docker)
- ![Docker Compose](https://img.shields.io/badge/Docker--Compose-Latest-2496ED?style=flat-square&logo=docker)

---

## 🚀 Bắt Đầu Ngay!

Nền tảng này sẵn sàng cho các cửa hàng bán lẻ thức ăn muốn tăng cường trải nghiệm khách hàng bằng AI.

**Được xây dựng bởi Claude Code | Cập nhật: 2026-07-02**

