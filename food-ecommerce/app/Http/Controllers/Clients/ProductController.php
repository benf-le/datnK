<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with(['firstImage', 'reviews'])->where('status', 'in_stock')->paginate(9);

        $productsHighRate = Product::with(['firstImage', 'reviews'])->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating')->limit(2)->get();

        return view('clients.pages.products', compact('categories', 'products', 'productsHighRate'));
    }

    public function filter(Request $request)
    {
        $query = Product::with(['firstImage', 'reviews']);

        //Filter Category if exist
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        //Filter Price if exist
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        //Filter SortBy if exist
        if ($request->has('category_id') && $request->category_id != '') {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }

        $products = $query->paginate(9);

        // foreach ($products as $product) {
        //     $product->image_url = $product->firstImage?->image_path ?
        //         asset('storage/' . $product->firstImage->image_path) :
        //         asset('storage/uploads/products/product-default.png');
        // }

        return response()->json([
            'products' => view('clients.components.products_grid', compact('products'))->render(),
            'pagination' => $products->links('clients.components.pagination.pagination_custom')->render(),
        ]);
    }

    public function detail($slug)
    {
        $product = Product::with(['category', 'images', 'reviews.user'])->where('slug', $slug)->firstOrFail();

        // Get product in the same
        $relatedProducts = Product::with(['firstImage', 'reviews'])->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();

        // Call API on Python to get retlated Products
        try {
            $apiUrl = 'http://127.0.0.1:5555/api/product-recommendation';
            $response = Http::timeout(1.5)->connectTimeout(1.0)->get($apiUrl, [
                'product_id' => $product->id
            ]);

            if ($response->successful()) {
                $listId = $response->json('related_products');

                $relatedProducts = Product::with(['firstImage', 'reviews'])->whereIn('id', $listId)->get();
            }
        } catch (\Throwable $e) {
            \Log::error('Error when call API: ' . $e->getMessage());
        }

        //Calculate avg rating
        $avegareRating = round($product->reviews()->avg('rating') ?? 0, 1);

        $hasPurchased = false;
        $hasReviewed = false;

        if (Auth::check()) {
            $user = Auth::user();

            $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'completed');
            })->where('product_id', $product->id)->exists();

            $hasReviewed = Review::where('user_id', $user->id)->where('product_id', $product->id)->exists();
        }

        return view('clients.pages.product-detail', compact('product', 'relatedProducts', 'hasPurchased', 'hasReviewed', 'avegareRating'));
    }
}
