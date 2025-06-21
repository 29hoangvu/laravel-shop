

<nav class="col-md-3 col-lg-2 d-md-block sidebar ">
<div class="bg-light border-end" id="sidebar-wrapper" style="width: 250px;">
    <div class="sidebar-heading border-bottom bg-white text-center py-4">



                <strong>Tester1</strong><br>
                <small class="text-muted">Admin</small>


    </div>

    <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action active" data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="true" aria-controls="menu1">
            <i class="fa fa-th-large me-2"></i>Quản lý thông tin
        </a>
        <div class="collapse show" id="menu1">
            <a href="{{ route('admindashboard.home.index') }}" class="list-group-item list-group-item-action">Trang chủ</a>
            <a href="{{ route('admindashboard.products.index') }}" class="list-group-item list-group-item-action">Quản lý sản phẩm</a>
            <a href="{{route('admindashboard.category.index')}}" class="list-group-item list-group-item-action">Quản lý danh mục</a>
            <a href="{{ route('admindashboard.invoice.index') }}" class="list-group-item list-group-item-action">Quản lý hóa đơn</a>
            <a href="{{ route('admindashboard.staff.index') }}" class="list-group-item list-group-item-action">Quản lý nhân viên</a>
            <a href="dashboard_3.html" class="list-group-item list-group-item-action text-danger">Đăng xuất</a>
        </div>
    </div>
</div>
</nav>
    <!-- Main content here -->