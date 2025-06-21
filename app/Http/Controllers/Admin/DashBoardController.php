<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Invoice;
class DashBoardController extends Controller
{
    public function index(){
        $productCount = Product::count();
        $invoiceCount = Invoice::count();
        $invoiceCompletedCount = Invoice::where('order_status','completed')->count();
        return view('admindashboard.home.index',compact('productCount','invoiceCount','invoiceCompletedCount'));
    }

}

