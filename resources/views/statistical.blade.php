@extends('master')
@section('content')
<span class="thong_ke">
    <div class="count_container count_sp">
    <span data-feather="box" class="align-text-bottom" id="icon-tk"></span>
    <h5>Số lượng sản phẩm</h5>
    <span>Đang có: {{$quanlityProduct}}</span><br/>
    <span>Tổng tiền nhập hàng: {{$totalWarehouse}}đ</span>
    </div>
    <div class="count_container count_hd">
    <span data-feather="shopping-bag" class="align-text-bottom" id="icon-tk"></span>
    <h5>Số lượng hóa đơn</h5>
    <span>Hóa đơn đang giao -> thanh toán: {{$inVoice}}</span><br/>
    <span>Đã hủy: {{$backInvoice}}</span><br/>
    <span>Tổng tiền hóa đơn xuất: {{$totalInvoice}}đ</span>
    </div>
    <div class="count_container count_nd">
    <span data-feather="users" class="align-text-bottom" id="icon-tk"></span>
    <h5>Số lượng người dùng</h5>    
    <span>Tổng số: {{$cusTomer}}</span>
    </div>

    <div class="count_container sp_top">
    <span data-feather="shopping-cart" class="align-text-bottom" id="icon-tk"></span>
    <h5>Sản phẩm bán chạy</h5>
    @foreach ($sellProduct as $item)
    <span>{{$item->product->name}} - Số lượng: {{$item->totalpd}}</span><br/>
    @endforeach
    </div>
 </span><br><br>
 <h4>Thống kê theo biểu đồ hóa đơn:</h4>

 
 <div class="option-m-y">
    <div class="doanh_thu">
        <label for="doanh-thu">Doanh thu:</label>
        <span id="doanh-thu"></span>đ
    </div>
    <!-- <div class="lai"> Lãi: <span id='lai'></span>đ</div> -->
    <div class="sp-da-ban">
        <label for="so-luong">Số lượng sản phẩm đã bán:</label>
        <span id="so-luong"></span>
    </div>
    <div class="hd-da-ban">
        <label for="so-luong-hoa-don">Số lượng đơn hàng:</label>
        <span id="so-luong-hoa-don"></span>
    </div>
    <div class="select-box">
        <select id="monthSelect">
            <option value="0" disabled selected>Chọn tháng</option>
            <!-- Thêm các tùy chọn tháng từ 1 đến 12 -->
        </select>
        <select id="yearSelect">
            <option value="0" disabled selected>Chọn năm</option>
            <!-- Thêm các tùy chọn năm, ví dụ: từ 2020 đến 2030 -->
        </select>
    </div>
    <button class="btn btn-info" id="thong-ke">Thống kê</button>
</div>

 <canvas id="orderChart"></canvas>
@endsection