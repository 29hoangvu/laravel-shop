<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chuyển đến VNPay...</title>
</head>
<body>
    <form id="vnpayForm" action="{{ url('vnpay_payment') }}" method="POST">
        @csrf
        <input type="hidden" name="invoice_id" value="{{ $invoice_id }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="email" value="{{ $email }}">
    </form>

    <script>
        document.getElementById('vnpayForm').submit();
    </script>
</body>
</html>
