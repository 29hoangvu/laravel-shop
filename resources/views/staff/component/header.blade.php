<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">Staff Panel</a>
    <div class="collapse navbar-collapse justify-content-end">
        <form action="{{ route('staff.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light">Đăng xuất</button>
        </form>
    </div>
</nav>
