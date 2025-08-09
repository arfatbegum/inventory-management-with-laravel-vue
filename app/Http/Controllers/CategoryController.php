<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryList(Request $request)
    {
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        $categories = Category::where('user_id', $user_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ], 200);
    }

    function CreateCategory(Request $request)
    {
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        if (!$request->has('name') || empty(trim($request->input('name')))) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category name is required'
            ], 400);
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'user_id' => $user_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    function DeleteCategory(Request $request)
    {
        $category_id = $request->input('category_id');
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        if (!$category_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category ID is required'
            ], 400);
        }

        $category = Category::where('id', $category_id)->where('user_id', $user_id)->first();

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found or unauthorized'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }


    function CategoryById(Request $request)
    {
        $category_id = $request->input('category_id');
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        if (!$category_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category ID is required'
            ], 400);
        }

        $category = Category::where('id', $category_id)->where('user_id', $user_id)->first();

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found or unauthorized'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 200);
    }


    public function UpdateCategory(Request $request)
    {
        $category_id = $request->input('category_id');
        $user_id = $request->header('id');
        $name = $request->input('name');

        if (!$category_id || !$user_id || !$name) {
            return response()->json([
                'status' => 'fail',
                'message' => 'category_id, user_id (header), and name are required'
            ], 400);
        }

        $category = Category::where('id', $category_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found or unauthorized'
            ], 404);
        }

        $category->update([
            'name' => $name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }
}
