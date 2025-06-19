@php
    $invoice_id = time(); // Mã đơn hàng tạm
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chuyển hướng VNPay</title>
</head>
<body onload="document.forms['vnpayForm'].submit()">
    <form name="vnpayForm" method="POST" action="{{ url('/vnpay_payment') }}">
        @csrf
        <input type="hidden" name="invoice_id" value="{{ $invoice_id }}">
        <input type="hidden" name="amount" value="{{ session('total_amount') }}">
        <input type="hidden" name="email" value="{{ $email }}">
    </form>
</body>
</html>