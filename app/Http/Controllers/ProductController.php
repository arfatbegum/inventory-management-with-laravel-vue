<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    function Product(Request $request)
    {
        $user_id = $request->header('id');

        $list = Product::with('category:id,name')
            ->where('user_id', $user_id)
            ->get();

        return Inertia::render('Product', ['list' => $list]);
    }


    function CreateAndUpdateProductPage(Request $request)
    {
        try {
            $product_id = $request->query('id');
            $user_id = $request->header('id');

            $product = null;
            if ($product_id && $product_id != 0) {
                $product = Product::where('id', $product_id)
                    ->where('user_id', $user_id)
                    ->first();
            }

            $categories = Category::where('user_id', $user_id)->get(['id', 'name']);

            return Inertia::render('CreateAndUpdateProduct', [
                'product' => $product,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Failed to load product page',
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    function CreateProduct(Request $request)
    {
        try {
            $user_id = $request->header('id');
            Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img_url'     => $request->input('img_url'),
                'category_id' => $request->input('category_id'),
                'user_id' => $user_id
            ]);
            $data = ['message' => 'Product Created Successfully', 'status' => true, 'error' => ''];
        } catch (Exception $e) {
            $data = ['message' => 'Product Creation Failed', 'status' => false, 'error' => $e->getMessage()];
        }
        return redirect()->route('Product')->with($data);
    }


    public function ProductList(Request $request)
    {
        try {
            $user_id = $request->header('id');

            $products = Product::with('category:id,name')
                ->where('user_id', $user_id)
                ->get();

            return Inertia::render('ProductList', [
                'list' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch Product list',
                'details' => $e->getMessage()
            ], 500);
        }
    }



    function ProductById(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $product_id = $request->input('id');
            return Product::where('id', $product_id)->where('user_id', $user_id)->first();
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch Product', 'details' => $e->getMessage()], 500);
        }
    }

    function UpdateProduct(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $product_id = $request->input('id');

            Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img_url' => $request->input('img_url'),
                'category_id' => $request->input('category_id')
            ]);
            $data = ['message' => 'Product Updated Successfully', 'status' => true, 'error' => ''];
        } catch (Exception $e) {
            $data = ['message' => 'Product Update Failed', 'status' => false, 'error' => $e->getMessage()];
        }
        return redirect()->route('Product')->with($data);
    }

    function DeleteProduct($id, Request $request)
    {
        try {
            $user_id = $request->header('id');

            Product::where('id', $id)
                ->where('user_id', $user_id)
                ->delete();

            $data = [
                'message' => 'Product Deleted Successfully',
                'status'  => true,
                'error'   => ''
            ];
        } catch (Exception $e) {
            $data = [
                'message' => 'Product Delete Failed',
                'status'  => false,
                'error'   => $e->getMessage()
            ];
        }

        return redirect()->route('Product')->with($data);
    }
}
