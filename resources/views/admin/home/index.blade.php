@extends('admin.component.layout')

@section('title', 'Trang chủ')
@section('content')

<style>
    .card-custom {
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    .card-custom:hover {
        transform: translateY(-5px);
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
    }
    .chart-container {
        position: relative;
        height: 400px;
        margin-bottom: 30px;
    }
    .filter-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }
    .export-btn {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    .loading {
        text-align: center;
        padding: 20px;
    }
</style>

<div class="container mt-1">
    <div class="row g-3">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card-custom bg-warning shadow p-3">
                <i class="fas fa-th-list fa-2x"></i>
                <h3 class="mb-1">Tổng số hóa đơn: {{$invoiceCount}}</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card-custom bg-success shadow p-3">
                <i class="fas fa-coffee fa-2x"></i>
                <h2 class="mb-1">Tổng số đã xử lý: {{$invoiceCompletedCount}}</h2>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card-custom bg-danger shadow p-3">
                <i class="fas fa-calendar-day fa-2x"></i>
                <h3 class="mb-1">Tổng số sản phẩm: {{$productCount}}</h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Header -->
    <div class="row py-3 m-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-chart-line me-2"></i>Báo cáo thống kê doanh thu</h2>
        </div>
    </div>

    <!-- Navigation Pills -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill" id="reportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="time-tab" data-bs-toggle="pill" data-bs-target="#time-content" type="button" role="tab">
                        <i class="fas fa-clock me-2"></i>Thống kê theo thời gian
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="customer-tab" data-bs-toggle="pill" data-bs-target="#customer-content" type="button" role="tab">
                        <i class="fas fa-user-friends me-2"></i>Thống kê theo khách hàng
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="product-tab" data-bs-toggle="pill" data-bs-target="#product-content" type="button" role="tab">
                        <i class="fas fa-box me-2"></i>Thống kê theo sản phẩm
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="reportTabsContent">

        <!-- Thống kê theo thời gian -->
        <div class="tab-pane fade show active" id="time-content" role="tabpanel">
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Từ ngày:</label>
                        <input type="date" class="form-control" id="timeFromDate" value="{{ Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Đến ngày:</label>
                        <input type="date" class="form-control" id="timeToDate" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kiểu hiển thị:</label>
                        <select class="form-select" id="timeDisplayType">
                            <option value="overview">Tổng quan</option>
                            <option value="detail">Chi tiết</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" onclick="updateTimeChart()">
                                <i class="fas fa-search me-1"></i>Lọc
                            </button>
                            <button class="btn export-btn" onclick="exportToExcel('time')">
                                <i class="fas fa-file-excel me-1"></i>Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-custom">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Biểu đồ doanh thu theo thời gian</h5>
                        </div>
                        <div class="card-body">
                            <div class="loading" id="timeLoading">
                                <i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...
                            </div>
                            <div class="chart-container" style="display: none;">
                                <canvas id="timeChart"></canvas>
                            </div>
                            <div id="timeDetailTable" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ngày</th>
                                            <th>Số hóa đơn</th>
                                            <th>Doanh thu</th>
                                        </tr>
                                    </thead>
                                    <tbody id="timeTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Thống kê theo khách hàng -->
        <div class="tab-pane fade" id="customer-content" role="tabpanel">
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Kiểu hiển thị:</label>
                        <select class="form-select" id="customerDisplayType">
                            <option value="overview">Tổng quan</option>
                            <option value="detail">Chi tiết</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" onclick="updateCustomerChart()">
                                <i class="fas fa-search me-1"></i>Lọc
                            </button>
                            <button class="btn export-btn" onclick="exportToExcel('customer')">
                                <i class="fas fa-file-excel me-1"></i>Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-custom">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Biểu đồ doanh thu theo khách hàng (Top 10)</h5>
                        </div>
                        <div class="card-body">
                            <div class="loading" id="customerLoading">
                                <i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...
                            </div>
                            <div class="chart-container" style="display: none;">
                                <canvas id="customerChart"></canvas>
                            </div>
                            <div id="customerDetailTable" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Khách hàng</th>
                                            <th>Số đơn hàng</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customerTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê theo sản phẩm -->
        <div class="tab-pane fade" id="product-content" role="tabpanel">
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Kiểu hiển thị:</label>
                        <select class="form-select" id="productDisplayType">
                            <option value="overview">Tổng quan</option>
                            <option value="detail">Chi tiết</option>
                            <option value="sales">Doanh số sản phẩm</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" onclick="updateProductChart()">
                                <i class="fas fa-search me-1"></i>Lọc
                            </button>
                            <button class="btn export-btn" onclick="exportToExcel('product')">
                                <i class="fas fa-file-excel me-1"></i>Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-custom">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Biểu đồ doanh thu theo sản phẩm (Top 10)</h5>
                        </div>
                        <div class="card-body">
                            <div class="loading" id="productLoading">
                                <i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...
                            </div>
                            <div class="chart-container" style="display: none;">
                                <canvas id="productChart"></canvas>
                            </div>
                            <div id="productDetailTable" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Số lượng bán</th>
                                            <th>Doanh thu</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.component.script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@include('admin.home.chart')

@endsection
