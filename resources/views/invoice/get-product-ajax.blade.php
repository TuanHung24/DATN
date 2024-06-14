<table class="table hd-ctsp" id='table-hd-ctsp'>
    <thead>
        <tr>
            <th scope="col">Màu sắc</th>
            <th scope="col">Dung lượng</th>
            <th scope="col">Giá bán</th>
            <th scope="col">Số lượng tồn</th>

            <th scope="col">Giảm giá(%)</th>
            <th scope="col">Giá sau khi giảm</th>

            <th scope="col">Nhập số lượng mua</th>
            <th scope="col">Chọn mua</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productDetail as $product)
        <tr>
            <input type="hidden" value="{{ $product->product_id }}" name="product_id" id="product-id" />
            <td id="td-color">{{ $product->color->name }}<input type="hidden" value="{{ $product->color->id }}" id="color-id" /></td>
            <td id="td-capacity">{{ $product->capacity->name }}<input type="hidden" value="{{ $product->capacity->id }}" id="capacity-id" /></td>
            <td>{{ $product->price_formatted }}</td>
            <td>{{ $product->quantity }}</td>

            @php
                $activeDiscount = $product->discount_detail->first(function($discountDetail) {
                    $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');
                    return $discountDetail->discount->date_start <= $now && $discountDetail->discount->date_end >= $now;
                });
            @endphp

            @if($activeDiscount)
            <td>{{ $activeDiscount->percent }}</td>
            <td>{{ $activeDiscount->price_formatted }}<input type="hidden" value="{{ $activeDiscount->price }}" name="price" id="price-id" /></td>
            @else
            <td>0</td>
            <td>{{$product->price_formatted}}<input type="hidden" value="{{ $product->price }}" name="price" id="price-id" /></td>
            @endif

            <td><input type="number" max="{{ $product->quantity }}" value="1" min="1" name="quantity" id='quantity-id' /></td>
            <td><input type="checkbox" name="buy" id="buy-id"></td>
        </tr>
        @endforeach

    </tbody>
</table>
