<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-dark text-light">

    @include('staff.partials.header')

    <div class="d-flex">
        @include('staff.partials.sidebar')

        <main class="flex-fill p-4" style="min-height: 100vh;">
            @yield('content')
        </main>
    </div>

    @include('staff.partials.footer')

</body>
</html>
