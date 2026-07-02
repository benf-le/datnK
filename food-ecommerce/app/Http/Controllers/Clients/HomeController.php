<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with([
                'products.firstImage', 
                'products.reviews', 
                'children.products.firstImage', 
                'children.products.reviews'
            ])
            ->get();

        foreach ($categories as $category) {
            $products = $category->products;
            
            foreach ($category->children as $child) {
                $products = $products->merge($child->products);
            }
            
            $category->setRelation('products', $products);

            foreach ($category->products as $product) {
                $product->image_url = $product->firstImage?->image_path ? 
                    asset('storage/' . $product->firstImage->image_path) : 
                    asset('storage/uploads/products/product-default.png');
            }
        }

        $bestSellingProducts = Product::select('products.*')
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->selectRaw('SUM(order_items.quantity) as total_sold')
        ->groupBy('products.id', 'products.name', 'products.slug', 'products.category_id', 'products.description', 'products.price', 'products.stock', 'products.status', 'products.unit', 'products.created_at', 'products.updated_at')
        ->orderByDesc('total_sold')
        ->limit(10)
        ->get();

        return view('clients.pages.home', compact('categories', 'bestSellingProducts'));
    }
}
