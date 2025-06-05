<!DOCTYPE html>
<html>

<head>
    @include('admindashboard.component.header')

</head>

<body>
    <div id="wrapper">
        @include('admindashboard.component.sidebar')

        <div id="page-wrapper" class="gray-bg">
            @include('admindashboard.component.nav')
            @include($template)
            @include('admindashboard.component.footer')
        </div>
    </div>

    @include('admindashboard.component.script')

</body>

</html>