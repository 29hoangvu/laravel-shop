<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Staff Dashboard')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <nav class="w-64 bg-gray-800 text-gray-200 flex flex-col">
        <div class="px-6 py-4 text-center border-b border-gray-700">
            <h1 class="text-xl font-semibold">Quản Lý Nhân Viên</h1>
        </div>
        <a href="{{ route('staff.dashboard') }}" 
           class="px-6 py-3 hover:bg-gray-700 hover:text-white font-semibold {{ request()->routeIs('staff.dashboard') ? 'bg-gray-900' : '' }}">Dashboard</a>
        <a href="#" class="px-6 py-3 hover:bg-gray-700 hover:text-white">Quản lý sản phẩm</a>
        <a href="#" class="px-6 py-3 hover:bg-gray-700 hover:text-white">Đơn hàng</a>
        <a href="#" class="px-6 py-3 hover:bg-gray-700 hover:text-white">Khách hàng</a>
        <a href="#" class="px-6 py-3 hover:bg-gray-700 hover:text-white">Báo cáo</a>
        <a href="#" class="px-6 py-3 hover:bg-gray-700 hover:text-white">Cài đặt</a>

        <form action="{{ route('staff.logout') }}" method="POST" class="mt-auto px-6 py-4">
            @csrf
            <button type="submit" 
                    class="w-full bg-red-600 hover:bg-red-700 transition-colors py-2 rounded text-white font-semibold">
                Đăng xuất
            </button>
        </form>
    </nav>

    <!-- Main content -->
    <div class="flex-grow flex flex-col">
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">@yield('header', 'Dashboard')</h2>
            <div>Chào, <strong>{{ Auth::guard('staff')->user()->name ?? 'Nhân viên' }}</strong></div>
        </header>

        <main class="flex-grow p-6 overflow-auto">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
