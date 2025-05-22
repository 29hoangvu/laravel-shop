@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Giỏ hàng</h1>
    
    @if(count($products) > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $id => $item)
                                <tr class="cart-item">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['product']->image ? asset('storage/' . $item['product']->image) : asset('images/no-image.jpg') }}" alt="{{ $item['product']->name }}" class="img-thumbnail me-3">
                                            <a href="{{ route('products.show', $item['product']->Product_id) }}">{{ $item['product']->name }}</a>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item['product']->price, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <div class="input-group" style="max-width: 120px">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateCartQuantity('{{ $id }}', 'decrease')">-</button>
                                            <input type="text" class="form-control text-center" value="{{ $item['quantity'] }}" readonly>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateCartQuantity('{{ $id }}', 'increase')">+</button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item['product']->price * $item['quantity'], 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="updateCartQuantity('{{ $id }}', 'remove')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body">
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
                    
                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100">
                        Tiến hành thanh toán
                    </a>
                </div>
            </div>
            
            <div class="card mt-3">
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
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h3>Giỏ hàng của bạn đang trống</h3>
            <p>Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function updateCartQuantity(productId, action) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            type: 'POST',
            data: {
                product_id: productId,
                action: action,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
</script>
@endsection