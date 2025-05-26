<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Giả sử bạn có model Order
use App\Models\OrderItem; // Giả sử bạn có model OrderItem cho chi tiết đơn hàng

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string',
        ]);

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tạo đơn hàng
        $order = new Order();
        $order->name = $request->input('name');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        $order->address = $request->input('address');
        $order->note = $request->input('note');
        $order->payment_method = $request->input('payment_method');
        $order->total_amount = 0; // Tính sau
        $order->status = 'pending'; // Trạng thái đơn hàng
        $order->save();

        $total = 0;

        // Lưu chi tiết đơn hàng
        foreach ($cart as $productId => $item) {
            $product = $item['product'];

            $quantity = $item['quantity'];
            $price = $product->price;

            $total += $price * $quantity;

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        // Cập nhật tổng tiền đơn hàng
        $order->total_amount = $total + 30000; // + phí vận chuyển 30k
        $order->save();

        // Xóa giỏ hàng sau khi đặt
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    }
}
