@if(isset($listAdmin) && $listAdmin->isNotEmpty())
<table class="table">
    <thead>
        <tr> 
            <th>Ảnh đại diện</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Tên tài khoản</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Giới tính</th>
            <th>Quyền</th>
            <th>Trạng thái</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listAdmin as $Admin)
        <tr>
            <td><img src="{{ $Admin->avatar_url ? asset($Admin->avatar_url) : asset('avt/avatar-rong.jpg') }}" class="avatar1" alt="avatar" /></td>
            <td>{{ $Admin->name }}</td>
            <td>{{ $Admin->email }}</td>
            <td>{{ $Admin->username }}</td>
            <td>{{ $Admin->phone }}</td>
            <td>{{ $Admin->address }}</td>
            <td>{{ $Admin->gender == 1 ? 'Nam' : 'Nữ' }}</td>
            <td>{{ $Admin->roles == 1 ? 'Quản lý' : ($Admin->roles == 2 ? 'Nhân viên' : ($Admin->roles == 3 ? 'Quản lý kho' : 'Không xác định')) }}</td>
            <td id="td-status">
                @if ($Admin->status === 1)
                <i class="fas fa-check-circle text-success" title="Hoạt động"></i>
                @else
                <i class="fas fa-times-circle text-danger" title="Không hoạt động"></i>
                @endif
            </td>
            <td id="task">
                <a href="{{ route('admin.update', ['id' => $Admin->id]) }}" title="Cập nhật" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> |
                @if($Admin->status === 1)
                <a href="{{ route('admin.lock', ['id' => $Admin->id]) }}" title="Khóa" class="btn btn-outline-warning"><i class="fas fa-lock"></i></a>
                @elseif($Admin->status === 0)
                <a href="{{ route('admin.unlock', ['id' => $Admin->id]) }}" title="Mở khóa" class="btn btn-outline-success"><i class="fas fa-unlock"></i></a>
                | <a href="{{ route('admin.delete', ['id' => $Admin->id]) }}" title="Xóa" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $listAdmin->links('vendor.pagination.default') }}
@else
<span class="error">Không có nhân viên nào!</span>
@endif
