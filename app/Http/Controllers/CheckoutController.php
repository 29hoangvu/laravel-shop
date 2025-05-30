<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Mail\InvoiceMail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'required|string|max:20',
            'email'           => 'required|email',
            'address'         => 'required|string|max:500',
            'payment_method'  => 'required|in:cod,vnpay',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $total += $product->price * $item['quantity'];
            }
        }
        $total += 30000; // Phí vận chuyển

        // Xử lý người dùng
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Cập nhật thông tin người dùng nếu có thay đổi
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->save();

        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'phone'    => $request->phone,
                    'address'  => $request->address,
                    'password' => Hash::make('12345678'), // mật khẩu mặc định
                ]);
            }
        }

        // Lưu hóa đơn
        $invoice = Invoice::create([
            'user_id'        => $user->user_id, // đúng tên cột trong CSDL
            'payment_status' => 'pending',
            'order_status'   => 'new',
            'total'          => $total,
            'created_at'     => now(),
        ]);

        // Lưu chi tiết hóa đơn
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice->invoice_id,
                    'product_id' => $product->product_id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }
        }

        // Xử lý thanh toán
        if ($request->payment_method == 'cod') {
            $details = InvoiceDetail::where('invoice_id', $invoice->invoice_id)->with('product')->get();
            Mail::to($user->email)->send(new InvoiceMail($invoice, $details));

            session()->forget('cart');
            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Hóa đơn đã gửi về email.');      
        } elseif ($request->payment_method == 'vnpay') {
            // Tạo view chứa form tự động gửi đến /vnpay_payment
            return view('vnpay.auto_submit', [
                'invoice_id' => $invoice->invoice_id,
                'amount'     => $total,
                'email'      => $user->email,
            ]);
        }

        return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
    }
}
