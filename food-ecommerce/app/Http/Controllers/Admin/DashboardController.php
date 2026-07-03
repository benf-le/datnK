<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $categories = Category::withCount('products')->get();
        $products = Product::where('stock', '>', 0)->get();
        $orders = Order::latest()->get();

        //Get list top3 best seller proucts

        $topSellingProducts = Product::withCount(['orderItems as total_sold' => function($query){
            $query->select(DB::raw("SUM(quantity)"));
        }])->orderByDesc('total_sold')->take(3)->get();

        $monthlyRevenue = Order::select(
            DB::raw("SUM(total_price) as revenue"),
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month")
        )->groupBy('month')->orderBy('month', 'ASC')->get();


        return view('admin.pages.dashboard', compact('users', 'categories', 'products', 'orders', 'topSellingProducts', 'monthlyRevenue'));
    }
}
