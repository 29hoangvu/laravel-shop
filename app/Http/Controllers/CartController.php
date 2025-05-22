<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị trang giỏ hàng
    public function index()
    {
        // Giả sử bạn có logic lấy dữ liệu giỏ hàng từ session hoặc database ở đây
        // Ví dụ:
        // $cartItems = session()->get('cart', []);
        // return view('cart.index', compact('cartItems'));

        return view('cart.index'); // Tạm thời trả về view cart.index
    }
}
