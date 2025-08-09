<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function CreateCustomer(Request $request)
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
                'message' => 'Customer name is required'
            ], 400);
        }

        $customer = Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'user_id' => $user_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully',
            'data' => $customer
        ], 201);
    }

    function CustomerList(Request $request)
    {
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        $customers = Customer::where('user_id', $user_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $customers
        ], 200);
    }

    function CustomerById(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        if (!$customer_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer ID is required'
            ], 400);
        }

        $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer not found or unauthorized'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $customer
        ], 200);
    }

    function UpdateCustomer(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        if (!$customer_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer ID is required'
            ], 400);
        }

        $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer not found or unauthorized'
            ], 404);
        }

        $customer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer updated successfully',
            'data' => $customer
        ], 200);
    }

    function DeleteCustomer(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User ID header missing'
            ], 400);
        }

        if (!$customer_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer ID is required'
            ], 400);
        }

        $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Customer not found or unauthorized'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully'
        ], 200);
    }
}
