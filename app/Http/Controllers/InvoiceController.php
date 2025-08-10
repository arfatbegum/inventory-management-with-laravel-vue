<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function invoiceCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');
            $products = $request->input('products');

            if (!$products || !is_array($products) || count($products) == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products provided'
                ], 422);
            }

            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $user_id,
                'customer_id' => $customer_id,
            ]);

            $invoiceID = $invoice->id;

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

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'invoice_id' => $invoiceID
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function invoiceSelect(Request $request)
    {
        $user_id = $request->header('id');
        $invoices = Invoice::where('user_id', $user_id)->with('customer')->get();

        return response()->json([
            'success' => true,
            'invoices' => $invoices
        ], 200);
    }

    public function invoiceDetails(Request $request)
    {
        $user_id = $request->header('id');
        $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
        $invoiceTotal = Invoice::where('user_id', '=', $user_id)->where('id', $request->input('inv_id'))->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', $request->input('inv_id'))
            ->where('user_id', $user_id)->with('product')
            ->get();

        if (!$customerDetails || !$invoiceTotal) {
            return response()->json([
                'success' => false,
                'message' => 'Customer or Invoice not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'customer' => $customerDetails,
            'invoice' => $invoiceTotal,
            'product' => $invoiceProduct,
        ], 200);
    }

    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');

            InvoiceProduct::where('invoice_id', $request->input('inv_id'))
                ->where('user_id', $user_id)
                ->delete();

            $deleted = Invoice::where('id', $request->input('inv_id'))->where('user_id', $user_id)->delete();

            DB::commit();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found or unauthorized'
                ], 404);
            }

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
