<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    public function showFormAddProduct()
    {
        $categories = Category::all();
        return view('admin.pages.product-add', compact('categories'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image',
        ]);

        $slug = Str::slug($request->name) . '-' . time();

        //Create Product
        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'unit' => $request->unit ?? 'kg',
            'status' => 'in_stock',
        ]);

        // Handle Image Uploads (if any)
        if ($request->hasFile('images')) {
            $index = 0;
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = "uploads/products/" . $imageName;

                $resizeimage = Image::make($image)->resize(600, 600)->encode();

                Storage::disk('public')->put($path, $resizeimage);

                // Save image path to database (assuming a ProductImage model exists)
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0 ? 1 : 0,
                    'sort_order' => $index,
                ]);

                if ($index === 0) {
                    $product->update(['thumbnail' => $path]);
                }
                $index++;
            }
        }

        return redirect()->route('admin.product.add')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function index()
    {
        $products = Product::with('category', 'images')->get();
        $categories = Category::all();
        return view('admin.pages.products', compact('products', 'categories'));
    }

    public function updateProduct(Request $request)
    {
        // Validation
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image',
        ]);

        $product = Product::findOrFail($request->id);

        // Update product details
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'unit' => $request->unit ?? 'kg',
        ]);

        // Handle Image Uploads (if any)
        if ($request->hasFile('images')) {
            //Delete old images
            $oldImage = ProductImage::where('product_id', $product->id)->get();
            foreach ($oldImage as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            //Remove old image database records
            ProductImage::where('product_id', $product->id)->delete();

            $index = 0;
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = "uploads/products/" . $imageName;

                $resizeimage = Image::make($image)->resize(600, 600)->encode();

                Storage::disk('public')->put($path, $resizeimage);

                // Save image path to database (assuming a ProductImage model exists)
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0 ? 1 : 0,
                    'sort_order' => $index,
                ]);

                if ($index === 0) {
                    $product->update(['thumbnail' => $path]);
                }
                $index++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật sản phẩm thành công.',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category_name' => $product->category->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'unit' => $product->unit,
                'status' => $product->status == 'in_stock' ? 'Còn hàng' : 'Hết hàng',
                'images' => $product->images->map(fn($img) => asset('storage/' . $img->image_path)),
            ]
        ]);
    }

    public function deleteProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->id);

        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the product
        $product->delete();

        return response()->json([
            'status' => true, 
            'message' => 'Xóa sản phẩm thành công.'
        ]);
    }
}
