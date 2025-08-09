<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function CreateProduct(Request $request)
    {
        $userId = $request->header('id');

        $product = Product::create([
            'name'        => $request->input('name'),
            'price'       => $request->input('price'),
            'unit'        => $request->input('unit'),
            'img_url'     => $request->input('img_url'),
            'category_id' => $request->input('category_id'),
            'user_id'     => $userId
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    }

    function ProductList(Request $request)
    {
        $userId = $request->header('id');
        $products = Product::where('user_id', $userId)->get();

        return response()->json([
            'status' => 'success',
            'data'   => $products
        ]);
    }

    function ProductById(Request $request)
    {
        $userId = $request->header('id');
        $product_id = $request->input('product_id');

        $product = Product::where('id', $product_id)
            ->where('user_id', $userId)
            ->first();

        if (!$product) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Product not found or unauthorized'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $product
        ]);
    }

    function UpdateProduct(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->input('product_id');

        $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();

        if (!$product) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Product not found or unauthorized'
            ], 404);
        }

        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $request->input('img_url'),
            'category_id' => $request->input('category_id'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully'
        ], 200);
    }


    function DeleteProduct(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->input('product_id');

        $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();

        if (!$product) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Product not found or unauthorized'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
