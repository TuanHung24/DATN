<table class="table hd-ctsp" id='table-hd-ctsp'>
    <thead>
        <tr>
            <th scope="col">Màu sắc</th>
            <th scope="col">Dung lượng</th>
            <th scope="col">Giá bán</th>
            <th scope="col">Số lượng tồn</th>
            <th scope="col">Nhập số lượng mua</th>
            <th scope="col">Chọn mua</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productDetail as $proDuct)
        <tr>
            <input type="hidden" value="{{$proDuct->product_id}}" name="product_id" id="product-id"/>
            <td id="td-color">{{ $proDuct->color->name }}<input type="hidden" value="{{ $proDuct->color->id }}" id="color-id"/></td>
            <td id="td-capacity">{{ $proDuct->capacity->name }}<input type="hidden" value="{{ $proDuct->capacity->id }}" id="capacity-id"/></td>
            <td>{{ $proDuct->price_formatted }}<input type="hidden" value="{{ $proDuct->price }}" name="price" id="price-id"/></td>
            <td>{{ $proDuct->quanlity }}</td>
            <td><input type="number" max="{{ $proDuct->quanlity }}" value="1" min="1" name="quanlity" id='quanlity-id'/></td>
            <td><input type="checkbox" name="buy" id="buy-id"></td>
        </tr>
        @endforeach
    </tbody>
</table>
