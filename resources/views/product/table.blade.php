@if(isset($listProduct) && $listProduct->isNotEmpty())
<table class="table">
    <thead>
        <tr class="title_sp">
            <th>Tên sản phẩm</th>
            <th>Mô tả</th>
            <th>Hãng sản phẩm</th>
            <th>Dòng sản phẩm</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listProduct as $Product)
        <tr>
            <td>{{ $Product->name }}</td>
            <td>{{ $Product->description }}</td>
            <td>{{ $Product->brand->name }}</td>
            <td>{{ $Product->product_series->name }}</td>
            <td class="chuc-nang-product">
                <a href="{{ route('product.update-images', ['id' => $Product->id]) }}" class="btn btn-outline-info" title="Cập nhật hình ảnh"><i class="fas fa-camera"></i></a> |
                <a href="{{ route('product.update', ['id' => $Product->id]) }}" class="btn btn-outline-primary" title="Cập nhật"><i class="fas fa-edit"></i></a> |
                <a href="{{ route('product.detail', ['id' => $Product->id]) }}" class="btn btn-outline-info" title="Chi tiết"><i class="fas fa-info-circle"></i></a> |
                <a href="{{ route('product.delete', ['id' => $Product->id]) }}" class="btn btn-outline-danger" title="Xóa"><i class="fas fa-trash"></i></a>
            </td>
        <tr>
            @endforeach
    </tbody>
</table>
{{ $listProduct->links('vendor.pagination.default') }}
@else
<span class="error">Không có sản phẩm nào!</span>
@endif