@extends('admin.component.layout')

@section('title', 'Trang chủ')
@section('content')


<div class="container mt-1">
    <div class="row g-3">

      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card-custom bg-warning shadow p-3 ">
          <i class="fas fa-th-list fa-2x"></i>
          <h3 class="mb-1">Tổng số hóa đơn:{{$invoiceCount}} </h3>

        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card-custom bg-success shadow p-3 ">
          <i class="fas fa-coffee fa-2x"></i>
          <h2 class="mb-1">Tổng số đã xử lý: {{$invoiceCompletedCount}}</h2>

        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card-custom bg-danger shadow p-3 ">
          <i class="fas fa-calendar-day fa-2x"></i>
          <h3 class="mb-1">Tổng số sản phẩm: {{$productCount}}</h3>

        </div>
      </div>

    </div>
  </div>







    @endsection
