@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CHI TIẾT SẢN PHẨM: {{$proDuct->name}}</h3>
</div>

<div class="product-container">
    <div class="product-columns">
        <div class="left-column">
            <div class="info-label">Hình ảnh:</div>
            <div class="image-gallery">
                @foreach($listImg as $img)
                <img src="{{ asset($img->img_url) }}" alt="Product Image" class="product-image">
                @endforeach
            </div>
        </div>
        <div class="right-column">
            <div class="product-info">
                <h4>Thông tin sản phẩm:</h4>
                <li class="info-li">
                    <p class="info-p">Tên sản phẩm:</p> 
                    <span class="info-value">{{ $proDuct->name }}</span>
                </li>
                <li class="info-li">
                    <p class="info-p">Dòng sản phẩm:</p> 
                    <span class="info-value">{{ $proDuct->product_series->name }}</span>
                </li>
                <li class="info-li">
                    <p class="info-p">Mô tả:</p> 
                    <span class="info-value">{{ $proDuct->description }}</span>
                </li>
                <li class="info-li">
                    <p class="info-p">Hãng:</p> 
                    <span class="info-value">{{ $proDuct->brand->name }}</span>
                </li>

                <ul class="info-list">
                    <li class="info-li">
                        <p class="info-p">Trọng lượng:</p>
                        <span class="info-value">{{ $productDescription->weight }} g</span>
                    </li>
                    <li class="info-li">
                        <p class="info-p">Hệ điều hành:</p>
                        <span class="info-value">{{ $productDescription->os }}</span>
                    </li>
                    <li class="info-li">
                        <p class="info-p">Pin:</p>
                        <span class="info-value">{{ $productDescription->battery }} mAh</span>
                    </li>
                    <li class="info-li">
                        <p class="info-p">Ram:</p>
                        <span class="info-value">{{ $productDescription->ram }} GB</span>
                    </li>
                    <li class="info-li">
                        <p class="info-p">Chip:</p>
                        <span class="info-value">{{ $productDescription->chip }}</span>
                    </li>
                    <li class="info-li">
                        <p class="info-p">Sim:</p>
                        <span class="info-value">{{ $productDescription->sims }}</span>
                    </li>
                </ul>

            </div>
        </div>
    </div>

    </div>
    @if(isset($listProductDetail) && $listProductDetail->isNotEmpty())
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr class="title_sp">
                    <th>Màu sắc</th>
                    <th>Dung lượng</th>
                    <th>Giá bán</th>
                    <th>Số lượng tồn</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listProductDetail as $productDetail)
                <tr>
                    <td>{{ $productDetail->color->name }}</td>
                    <td>{{ $productDetail->capacity->name }}</td>
                    <td>{{ $productDetail->price_formatted }}</td>
                    <td>{{ $productDetail->quantity }}</td>
                <tr>
                    @endforeach
            </tbody>
        </table>
        @else
        <h6></h6>
        @endif
    
</div>
    @endsection