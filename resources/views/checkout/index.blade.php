@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container">
    <h1 class="mb-4">Thanh toán</h1>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->name ?? old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ auth()->user()->phone ?? old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ auth()->user()->email ?? old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ giao hàng</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ auth()->user()->address ?? old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú đơn hàng (Không bắt buộc)</label>
                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                        </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Phương thức thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                        <label class="form-check-label" for="cod">
                            <i class="fas fa-money-bill-wave me-2"></i> Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                        <label class="form-check-label" for="bank">
                            <i class="fas fa-university me-2"></i> Chuyển khoản ngân hàng
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                        <label class="form-check-label" for="momo">
                            <i class="fas fa-wallet me-2"></i> Ví Momo
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Đơn hàng của bạn</h5>
                </div>
                <div class="card-body">
                    @php
                        $cart = session()->get('cart', []);
                        $total = 0;
                    @endphp
                    
                    @foreach($cart as $id => $item)
                        @php 
                            $product = App\Models\Product::find($id);
                            if ($product) {
                                $total += $product->price * $item['quantity'];
                            }
                        @endphp
                        
                        @if($product)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $product->name }} x {{ $item['quantity'] }}</span>
                            <span>{{ number_format($product->price * $item['quantity'], 0, ',', '.') }} VNĐ</span>
                        </div>
                        @endif
                    @endforeach
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>{{ number_format(30000, 0, ',', '.') }} VNĐ</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tổng cộng:</strong>
                        <strong>{{ number_format($total + 30000, 0, ',', '.') }} VNĐ</strong>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        Đặt hàng
                    </button>
                </div>
            </div>
            </form>
            
            <div class="card">
                <div class="card-body">
                    <h5>Mã giảm giá</h5>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
                        <button class="btn btn-secondary" type="button">Áp dụng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection