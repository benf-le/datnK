<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function showFormAddCate()
    {
        return view('admin.pages.categories-add');
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile("image")) {
            $imagePath = $request->file("image");
            $fileName = now()->timestamp . '_' . uniqid() . '.' . $imagePath->getClientOriginalExtension();
            $imagePath = $imagePath->storeAs('uploads/categories', $fileName, 'public');
        }

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.add')->with('success', 'Thêm danh mục thành công.');
    }

    public function index()
    {
        $categories = Category::all();

        return view('admin.pages.categories', compact('categories'));
    }

    public function updatdeCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);
            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Danh mục không tồn tại.'
                ], 404);
            }

            $category->name = $request->name;
            $category->description = $request->description;

            if ($request->hasFile("image")) {
                if ($category->image) {
                    // delete old image
                    Storage::disk('public')->delete($category->image);
                }

                $imagePath = $request->file("image");
                $fileName = now()->timestamp . '_' . uniqid() . '.' . $imagePath->getClientOriginalExtension();
                $imagePath = $imagePath->storeAs('uploads/categories', $fileName, 'public');

                $category->image = $imagePath;
            }

            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật danh mục thành công.',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'image' => $category->image ? asset('storage/' . $category->image) : null
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Đã có lỗi xảy ra.'
            ], 500);
        }
    }

    public function deleteCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);
            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Danh mục không tồn tại.'
                ], 404);
            }

            // delete image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa danh mục thành công.'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Đã có lỗi xảy ra.'
            ], 500);
        }
    }
}
