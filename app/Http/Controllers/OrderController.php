<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $invoices = Invoice::where('user_id', $user->user_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('orders.index', compact('invoices'));
    }

}