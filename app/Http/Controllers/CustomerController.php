<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    function Customer(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $list = Customer::where('user_id', $user_id)->get();
            return Inertia::render('Customer', ['list' => $list]);
        } catch (Exception $e) {
            return Inertia::render('Customer', ['list' => [], 'error' => $e->getMessage()]);
        }
    }

    function CreateAndUpdateCustomerPage(Request $request)
    {
        try {
            $customer_id = $request->query('id');
            $user_id = $request->header('id');

            $list = Customer::where('id', $customer_id)
                ->where('user_id', $user_id)
                ->first();

            return Inertia::render('CreateAndUpdateCustomer', ['list' => $list]);
        } catch (Exception $e) {
            return Inertia::render('CreateAndUpdateCustomer', [
                'list' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }


    function CreateCustomer(Request $request)
    {
        try {
            $user_id = $request->header('id');
            Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'user_id' => $user_id
            ]);
            $data = ['message' => 'Customer Created Successfully', 'status' => true, 'error' => ''];
        } catch (Exception $e) {
            $data = ['message' => 'Customer Creation Failed', 'status' => false, 'error' => $e->getMessage()];
        }
        return redirect()->route('Customer')->with($data);
    }

    function CustomerList(Request $request)
    {
        try {
            $user_id = $request->header('id');
            return Customer::where('user_id', $user_id)->get();
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch customer list', 'details' => $e->getMessage()], 500);
        }
    }

    function CustomerById(Request $request)
    {
        try {
            $customer_id = $request->input('id');
            $user_id = $request->header('id');
            return Customer::where('id', $customer_id)->where('user_id', $user_id)->first();
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch customer', 'details' => $e->getMessage()], 500);
        }
    }

    function UpdateCustomer(Request $request)
    {
        try {
            $customer_id = $request->input('id');
            $user_id = $request->header('id');
            Customer::where('id', $customer_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
            ]);
            $data = ['message' => 'Customer Updated Successfully', 'status' => true, 'error' => ''];
        } catch (Exception $e) {
            $data = ['message' => 'Customer Update Failed', 'status' => false, 'error' => $e->getMessage()];
        }
        return redirect()->route('Customer')->with($data);
    }

    function DeleteCustomer($id, Request $request)
{
    try {
        $user_id = $request->header('id');

        Customer::where('id', $id)
            ->where('user_id', $user_id)
            ->delete();

        $data = [
            'message' => 'Customer Deleted Successfully',
            'status'  => true,
            'error'   => ''
        ];
    } catch (Exception $e) {
        $data = [
            'message' => 'Customer Delete Failed',
            'status'  => false,
            'error'   => $e->getMessage()
        ];
    }

    return redirect()->route('Customer')->with($data);
}

}
