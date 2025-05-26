<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Bạn cần có model Order
use App\Models\OrderItem; // Nếu có bảng chi tiết đơn hàng
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng đang trống');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank,momo,vnpay',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng đang trống');
        }

        // Tạo đơn hàng mới
        $order = new Order();
        $order->user_id = Auth::id();
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->note = $request->note;
        $order->payment_method = $request->payment_method;
        $order->status = 'pending'; // trạng thái đơn hàng
        $order->total = 0; // sẽ tính lại sau
        $order->save();

        $total = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) continue;
            $quantity = $item['quantity'];
            $price = $product->price;

            // Lưu chi tiết đơn hàng (giả sử bạn có bảng order_items)
            $order->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $price * $quantity,
            ]);

            $total += $price * $quantity;
        }

        $order->total = $total;
        $order->save();

        // Nếu chọn VNPay thì redirect sang VNPay
        if ($request->payment_method === 'vnpay') {
            return $this->redirectToVNPay($order);
        }

        // Xóa giỏ hàng khi đã đặt xong
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', 'Đặt hàng thành công');
    }

    protected function redirectToVNPay(Order $order)
    {
        // Tạo url redirect sang VNPay, bạn cần cài đặt thông tin VNPay

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_TmnCode = env('VNP_TMNCODE'); // Mã website tại VNPay
        $vnp_HashSecret = env('VNP_HASHSECRET'); // Chuỗi bí mật
        $vnp_Returnurl = route('checkout.vnpayReturn');

        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order->id;
        $vnp_Amount = $order->total * 100; // VNPay tính theo đơn vị nhỏ hơn VNĐ (vd: 1 VNĐ = 100)
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData, '', '&');
        $hashdata = implode('&', array_map(
            fn($k, $v) => $k . '=' . $v,
            array_keys($inputData),
            array_values($inputData)
        ));

        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnp_SecureHash;

        return redirect()->away($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        // Xử lý callback từ VNPay, check chữ ký, cập nhật trạng thái đơn hàng

        $vnp_HashSecret = env('VNP_HASHSECRET');
        $inputData = $request->all();

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = implode('&', array_map(
            fn($k, $v) => $k . '=' . $v,
            array_keys($inputData),
            array_values($inputData)
        ));

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $orderId = $request->get('vnp_TxnRef');
        $order = Order::find($orderId);

        if ($secureHash === $vnp_SecureHash) {
            if ($request->get('vnp_ResponseCode') == '00') {
                // Thanh toán thành công
                $order->status = 'paid';
                $order->save();

                return redirect()->route('orders.show', $orderId)->with('success', 'Thanh toán thành công!');
            } else {
                // Thanh toán thất bại
                $order->status = 'failed';
                $order->save();

                return redirect()->route('orders.show', $orderId)->with('error', 'Thanh toán thất bại!');
            }
        } else {
            return redirect()->route('orders.show', $orderId)->with('error', 'Chữ ký không hợp lệ!');
        }
    }
}
