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
        @foreach($listProductDetail as $proDuct)
        <tr>
            <td id="td-color">{{ $proDuct->color->name }}<input type="hidden" value="{{ $proDuct->color->id }}" id="color-id"/></td>
            <td id="td-capacity">{{ $proDuct->capacity->name }}<input type="hidden" value="{{ $proDuct->capacity->id }}" id="capacity-id"/></td>
            <td>{{ $proDuct->price }}<input type="hidden" value="{{ $proDuct->price }}" name="price" id="price-id"/></td>
            <td>{{ $proDuct->quantity }}</td>
            <td><input type="number" max="{{ $proDuct->quantity }}" min="1" name="quantity" id='quantity-id'/></td>
            <td><input type="checkbox" name="buy" id="buy-id"></td>
        </tr>
        @endforeach
    </tbody>
</table>
