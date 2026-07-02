import os
from fastapi import FastAPI, HTTPException, Body, status
from fastapi.responses import JSONResponse
from pydantic import BaseModel, ConfigDict
from dotenv import load_dotenv

# Import các service của chúng ta
from rag_service import (
    async_ingest_document,
    async_ingest_product,
    async_generate_rag_response,
    async_qdrant_client,
    QDRANT_COLLECTION_NAME
)

# Load các biến môi trường
load_dotenv()

# Khởi tạo FastAPI App với Metadata đầy đủ (tốt cho SEO/Swagger API Docs)
app = FastAPI(
    title="Supplement Vector Data Product RAG System",
    description="Hệ thống Vector Data Product & RAG chuyên dụng cho Thực phẩm chức năng tích hợp Chatwoot.",
    version="1.0.0"
)


# --- PYDANTIC MODELS FOR REQUEST VALIDATION ---

class IngestRequest(BaseModel):
    text: str

    model_config = ConfigDict(
        json_schema_extra={
            "example": {
                "text": "Công ty TNHH Vibe Code có trụ sở tại 123 Đường Láng, Hà Nội. Giờ làm việc từ 8:00 sáng đến 17:30 chiều, từ thứ Hai đến thứ Sáu hàng tuần."
            }
        }
    )


class ProductIngestRequest(BaseModel):
    product_id: str
    name: str
    description: str
    price: float
    unit: str
    category: str

    model_config = ConfigDict(
        json_schema_extra={
            "example": {
                "product_id": "1",
                "name": "Táo đỏ Mỹ",
                "description": "Táo đỏ nhập khẩu trực tiếp từ Mỹ, vị ngọt thanh, giòn ngon tự nhiên.",
                "price": 150000.0,
                "unit": "kg",
                "category": "Trái cây nhập khẩu"
            }
        }
    )


class ChatMessageItem(BaseModel):
    role: str  # 'user' hoặc 'model'/'bot'/'assistant'
    message: str


class ChatQueryRequest(BaseModel):
    query: str
    history: list[ChatMessageItem] = []

    model_config = ConfigDict(
        json_schema_extra={
            "example": {
                "query": "Có táo đỏ ngon không em?",
                "history": [
                  {"role": "user", "message": "Chào bạn"},
                  {"role": "model", "message": "Chào bạn 👋! Tôi là trợ lý ảo hỗ trợ tìm kiếm sản phẩm. Tôi có thể giúp gì cho bạn hôm nay?"}
                ]
            }
        }
    )


# --- UTILITIES ---


# --- API ENDPOINTS ---

@app.get("/health", summary="Kiểm tra trạng thái hệ thống và kết nối DB")
async def health_check():
    """
    Kiểm tra trạng thái hoạt động của Server FastAPI và kết nối tới Vector DB Qdrant.
    """
    health_status = {
        "status": "healthy",
        "openai_api": "configured" if os.getenv("OPENAI_API_KEY") else "missing",
        "qdrant": "disconnected"
    }
    
    try:
        # Thử lấy thông tin collection để kiểm tra kết nối Qdrant bất đồng bộ
        await async_qdrant_client.collection_exists(QDRANT_COLLECTION_NAME)
        health_status["qdrant"] = "connected"
    except Exception as e:
        health_status["status"] = "unhealthy"
        health_status["qdrant_error"] = str(e)
        
    if health_status["status"] == "healthy":
        return JSONResponse(content=health_status, status_code=status.HTTP_200_OK)
    return JSONResponse(content=health_status, status_code=status.HTTP_503_SERVICE_UNAVAILABLE)


@app.post("/api/chat", summary="Hỏi đáp Chatbot RAG đồng bộ")
async def chat_rag_endpoint(payload: ChatQueryRequest):
    """
    API endpoint nhận câu hỏi của người dùng cùng lịch sử chat, 
    truy vấn Vector DB Qdrant để lấy context liên quan, gọi OpenAI LLM sinh phản hồi đồng bộ.
    """
    if not payload.query or not payload.query.strip():
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST, 
            detail="Nội dung câu hỏi (query) không được để trống."
        )
        
    try:
        # Gọi rag_service sinh câu trả lời
        answer = await async_generate_rag_response(
            query=payload.query.strip(),
            history=payload.history
        )
        
        return {
            "status": "success",
            "answer": answer
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Lỗi hệ thống khi xử lý RAG chat: {str(e)}"
        )


@app.post("/ingest", summary="Nhập tài liệu tri thức chung vào Vector DB")
async def ingest_data(payload: IngestRequest):
    """
    Endpoint nhận tài liệu dạng văn bản dài từ admin, thực hiện chunking, 
    embedding và lưu trữ các vector đại diện vào Qdrant bất đồng bộ.
    """
    if not payload.text or not payload.text.strip():
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST, 
            detail="Nội dung văn bản (text) không được để trống."
        )
        
    try:
        # Gọi rag_service bất đồng bộ để ingest tài liệu
        chunks_created = await async_ingest_document(payload.text)
        
        return {
            "status": "success",
            "message": "Nạp tài liệu tri thức thành công!",
            "chunks_created": chunks_created
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Lỗi hệ thống khi nạp tài liệu: {str(e)}"
        )


@app.post("/ingest/product", summary="Nạp hoặc Cập nhật 1 sản phẩm có cấu trúc")
async def ingest_single_product(payload: ProductIngestRequest):
    """
    API endpoint nhận thông tin 1 sản phẩm từ Admin CMS để nạp/cập nhật vector vào Qdrant.
    Được thiết kế theo mô hình 'Delete-then-Insert' để chống trùng lặp dữ liệu.
    """
    try:
        chunks_created = await async_ingest_product(
            product_id=payload.product_id.strip(),
            name=payload.name.strip(),
            description=payload.description.strip(),
            price=payload.price,
            unit=payload.unit.strip(),
            category=payload.category.strip()
        )
        return {
            "status": "success",
            "message": f"Nạp/Cập nhật sản phẩm '{payload.name}' thành công!",
            "chunks_created": chunks_created
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Lỗi hệ thống khi nạp sản phẩm '{payload.name}': {str(e)}"
        )


@app.delete("/ingest/product/{product_id}", summary="Xóa vector của 1 sản phẩm")
async def delete_single_product_vectors(product_id: str):
    """
    API endpoint xóa toàn bộ các vector liên quan đến product_id trong Qdrant.
    """
    try:
        from rag_service import async_delete_product_vectors
        await async_delete_product_vectors(product_id.strip())
        return {
            "status": "success",
            "message": f"Đã xóa toàn bộ vector của sản phẩm ID '{product_id}'."
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Lỗi hệ thống khi xóa sản phẩm '{product_id}': {str(e)}"
        )


@app.post("/ingest/products/bulk", summary="Nạp hàng loạt nhiều sản phẩm (Bulk Import)")
async def ingest_bulk_products(payload: list[ProductIngestRequest]):
    """
    API endpoint nhận danh sách nhiều sản phẩm để nạp hàng loạt.
    """
    if not payload:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail="Danh sách sản phẩm nạp không được để trống."
        )
        
    try:
        total_chunks = 0
        success_products = []
        
        # Gọi lần lượt nạp bất đồng bộ từng sản phẩm
        for prod in payload:
            chunks_created = await async_ingest_product(
                product_id=prod.product_id.strip(),
                name=prod.name.strip(),
                description=prod.description.strip(),
                price=prod.price,
                unit=prod.unit.strip(),
                category=prod.category.strip()
            )
            total_chunks += chunks_created
            success_products.append(prod.name)
            
        return {
            "status": "success",
            "message": f"Nạp hàng loạt thành công {len(payload)} sản phẩm!",
            "total_chunks_created": total_chunks,
            "products_imported": success_products
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Lỗi hệ thống khi nạp hàng loạt sản phẩm: {str(e)}"
        )


# Khởi chạy uvicorn
if __name__ == "__main__":
    import uvicorn
    port = int(os.getenv("PORT", 8000))
    print(f"--- Đang khởi động FastAPI Server tại port {port} ---")
    uvicorn.run("main:app", host="0.0.0.0", port=port, reload=True)

