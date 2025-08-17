<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller
{

    function Invoice(Request $request)
    {
        $user_id = $request->header('id');
        $list = Invoice::where('user_id', $user_id)->with('customer')->get();
        return Inertia::render('Invoice', ['list' => $list]);
    }

    function InvoiceDetailsPage(Request $request)
    {
        $user_id = $request->header('id');
        $invoice_id = $request->input('inv_id');

        // Fetch invoice
        $invoiceData = Invoice::where('user_id', $user_id)
            ->where('id', $invoice_id)
            ->first();

        if (!$invoiceData) {
            return redirect()->back()->with([
                'status' => false,
                'message' => 'Invoice not found.'
            ]);
        }

        // Fetch customer using customer_id from invoice
        $customer = Customer::where('user_id', $user_id)
            ->where('id', $invoiceData->customer_id)
            ->first();

        // Fetch products
        $products = InvoiceProduct::where('invoice_id', $invoice_id)
            ->where('user_id', $user_id)
            ->with('product')
            ->get();

        return Inertia::render('InvoiceDetailsPage', [
            'invoice' => [
                'customer' => $customer,
                'invoice' => $invoiceData,
                'product' => $products,
            ],
            'flash' => session('flash')
        ]);
    }

    function invoiceCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $user_id,
                'customer_id' => $customer_id,
            ]);

            $invoiceID = $invoice->id;
            $products = $request->input('products');

            foreach ($products as $EachProduct) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'user_id' => $user_id,
                    'product_id' => $EachProduct['product_id'],
                    'qty' =>  $EachProduct['qty'],
                    'sale_price' =>  $EachProduct['sale_price'],
                ]);
            }

            DB::commit();

            $data = ['message' => 'Invoice Created Successfully', 'status' => true, 'error' => ''];
            return  redirect()->route('Invoice')->with($data);
        } catch (Exception $e) {
            DB::rollBack();

            $data = ['message' => 'Invoice Creation Failed', 'status' => false, 'error' => ''];
            return  redirect()->route('Sale')->with($data);
        }
    }

    function invoiceSelect(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }

    function InvoiceDetails(Request $request)
    {
        $user_id = $request->header('id');
        $inv_id = $request->input('inv_id');
        $cus_id = $request->input('cus_id');

        $customer = Customer::where('user_id', $user_id)
            ->where('id', $cus_id)
            ->first();

        $invoice = Invoice::where('user_id', $user_id)
            ->where('id', $inv_id)
            ->first();

        $products = InvoiceProduct::where('invoice_id', $inv_id)
            ->where('user_id', $user_id)
            ->with('product')
            ->get();

        if (!$customer || !$invoice) {
            return Inertia::render('InvoiceDetailsPage', [
                'invoice' => null,
                'flash' => [
                    'status' => false,
                    'message' => 'Invoice or customer not found.'
                ]
            ]);
        }

        return Inertia::render('InvoiceDetailsPage', [
            'invoice' => [
                'customer' => $customer,
                'invoice' => $invoice,
                'product' => $products,
            ],
            'flash' => [
                'status' => true,
                'message' => 'Invoice details loaded successfully.'
            ]
        ]);
    }
function invoiceDelete(Request $request)
{
    DB::beginTransaction();
    try {
        $user_id = $request->header('id');
        $inv_id = $request->input('inv_id');

        // Delete invoice products
        InvoiceProduct::where('invoice_id', $inv_id)
            ->where('user_id', $user_id)
            ->delete();

        // Delete invoice
        Invoice::where('id', $inv_id)
            ->where('user_id', $user_id)
            ->delete();

        DB::commit();

        // After successful deletion, redirect to the Invoice list page.
        // Inertia will handle this as a full page reload, fetching the updated list.
        return redirect()->route('Invoice')->with([
            'message' => 'Invoice Deleted Successfully',
            'status' => true
        ]);
    } catch (Exception $e) {
        DB::rollBack();

        return redirect()->route('Invoice')->with([
            'message' => 'Invoice Delete Failed',
            'status' => false,
            'error' => $e->getMessage(),
        ]);
    }
}
}
