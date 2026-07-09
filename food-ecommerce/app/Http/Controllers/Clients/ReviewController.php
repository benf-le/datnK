<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        return view('clients.components.includes.review-list', compact('product'))->render();
    }

    public function createReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // 1. Check if user has purchased this product and the order status is completed
        $hasPurchased = \App\Models\OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'completed');
        })->where('product_id', $productId)->exists();

        if (!$hasPurchased) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chỉ có thể đánh giá sản phẩm sau khi đã mua hàng và đơn hàng hoàn tất.'
            ], 403);
        }

        // 2. Check if user has already reviewed this product
        $hasReviewed = Review::where('user_id', $userId)->where('product_id', $productId)->exists();
        if ($hasReviewed) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn đã đánh giá sản phẩm này rồi.'
            ], 400);
        }

        $review = new Review();
        $review->user_id = $userId;
        $review->product_id = $productId;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json([
            'status' => true,
            'message' => 'Đánh giá của bạn đã được gửi thành công!'
        ], 200);
    }
}
