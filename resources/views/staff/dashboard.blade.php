@extends('layouts.staff')

@section('title', 'Dashboard Nhân Viên')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-blue-600 text-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-2">Tổng sản phẩm</h3>
        <p class="text-3xl font-bold">150</p>
    </div>
    <div class="bg-green-600 text-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-2">Đơn hàng hôm nay</h3>
        <p class="text-3xl font-bold">23</p>
    </div>
    <div class="bg-yellow-400 text-gray-900 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-2">Khách hàng mới</h3>
        <p class="text-3xl font-bold">12</p>
    </div>
</div>

<section>
    <h3 class="text-xl font-semibold mb-4">Báo cáo hoạt động gần đây</h3>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nội dung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">1</td>
                    <td class="px-6 py-4 whitespace-nowrap">2025-05-25</td>
                    <td class="px-6 py-4 whitespace-nowrap">Phê duyệt đơn hàng #345</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Hoàn thành</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">2</td>
                    <td class="px-6 py-4 whitespace-nowrap">2025-05-24</td>
                    <td class="px-6 py-4 whitespace-nowrap">Cập nhật thông tin sản phẩm #128</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Đang chờ</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
