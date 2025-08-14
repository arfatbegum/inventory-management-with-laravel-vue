<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    function Category(Request $request)
    {
        $user_id = $request->header('id');
        $list = Category::where('user_id', $user_id)->get();
        return Inertia::render('Category', ['list' => $list]);
    }
    
    function CreateAndUpdateCategoryPage(Request $request)
    {
        $category_id = $request->query('id');
        $user_id = $request->header('id');
        $list = Category::where('id', $category_id)->where('user_id', $user_id)->first();
        return Inertia::render('CreateAndUpdateCategory', ['list' => $list]);
    }

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
        Category::create([
            'name' => $request->input('name'),
            'user_id' => $user_id
        ]);
        $data = ['message' => 'Category Create Successfully', 'status' => true, 'error' => ''];
        return  redirect()->route('Category')->with($data);
    }

    function DeleteCategory(Request $request)
    {
        try {
            $category_id = $request->id;
            $user_id = $request->header('id');
            Category::where('id', $category_id)->where('user_id', $user_id)->delete();
            $data = ['message' => 'Category Deleted Successfully', 'status' => true, 'error' => ''];
            return  redirect()->route('Category')->with($data);
        } catch (Exception $e) {
            $data = ['message' => 'Category Delete Failed', 'status' => false, 'error' => ''];
            return  redirect()->route('Category')->with($data);
        }
    }

    function CategoryById(Request $request)
    {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->first();
    }


    function UpdateCategory(Request $request)
    {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        Category::where('id', $category_id)->where('user_id', $user_id)->update([
            'name' => $request->input('name'),
        ]);
        $data = ['message' => 'Update Category Successfully', 'status' => true, 'error' => ''];
        return  redirect()->route('Category')->with($data);
    }
}
