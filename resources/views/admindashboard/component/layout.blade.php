<!DOCTYPE html>
<html>

<head>
    @include('admindashboard.component.header')

</head>
<style>
    .sidebar {
        transition: all 0.3s ease;
    }
    .sidebar.collapsed {
        margin-left: -250px;
    }
    /* Mobile responsive code... */
    </style>
<body>@include('admindashboard.component.nav')
    <div class="container-fluid">
        <div class="row">
    @include('admindashboard.component.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4 ">
            @yield('content')


        </main>

        </div>
    </div>
</body>

</html>