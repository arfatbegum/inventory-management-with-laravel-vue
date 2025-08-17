<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class DashboardController extends Controller
{
    function Invoice()
    {
        return Inertia::render('Invoice');
    }

    function Profile(Request $request)
     {
        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return Inertia::render('Profile',['list'=>$user]);
    }

    function Sale(Request $request)
    {
         $user_id = $request->header('id');
            $customerList = Customer::where('user_id', $user_id)->get();
            $productlist = Product::where('user_id', $user_id)->get();
            return Inertia::render('Sale', [
        'customers' => $customerList,
        'products' => $productlist,
    ]);
    }

    function Dashboard(Request $request)
      {
        $user_id=$request->header('id');
        $product= Product::where('user_id',$user_id)->count();
        $Category= Category::where('user_id',$user_id)->count();
        $Customer=Customer::where('user_id',$user_id)->count();
        $Invoice= Invoice::where('user_id',$user_id)->count();
        $total=  Invoice::where('user_id',$user_id)->sum('total');
        $vat= Invoice::where('user_id',$user_id)->sum('vat');
        $payable =Invoice::where('user_id',$user_id)->sum('payable');
        $data=[
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'invoice'=> $Invoice,
            'total'=> round($total,2),
            'vat'=> round($vat,2),
            'payable'=> round($payable,2)
        ];

        return Inertia::render('Dashboard',['list'=>$data]);
    }
}
