@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header fw-bold">Bài viết</div>
    <div class="card-body table-responsive">
        <!-- Form lọc -->
        <div class="row mb-3">
            <div class="col-md-4">
                <!-- Form lọc theo chủ đề -->
                <form method="GET" action="{{ route('admin.baiviet.danhsach') }}">
                    <div class="input-group mb-2">
                        <select name="chude_id" class="form-control">
                            <option value="">Tất cả chủ đề</option>
                            @foreach($chude as $cd)
                                <option value="{{ $cd->id }}" {{ request('chude_id') == $cd->id ? 'selected' : '' }}>
                                    {{ $cd->tenchude }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </form>

                <!-- Form tìm kiếm và sắp xếp theo tiêu đề -->
                <form method="GET" action="{{ route('admin.baiviet.danhsach') }}">
                    <div class="input-group mb-2">
                        <input type="text" name="tieude" class="form-control" placeholder="Tìm theo tiêu đề" value="{{ request('tieude') }}">
                        <select name="sort" class="form-control">
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Tìm</button>
                    </div>
                    <!-- Giữ lại chude_id nếu có -->
                    @if(request('chude_id'))
                        <input type="hidden" name="chude_id" value="{{ request('chude_id') }}">
                    @endif
                </form>

                <!-- Form sắp xếp theo ngày đăng -->
                <form method="GET" action="{{ route('admin.baiviet.danhsach') }}">
                    <div class="input-group">
                        <select name="date_sort" class="form-control">
                            <option value="">Sắp xếp theo ngày</option>
                            <option value="desc" {{ request('date_sort') == 'desc' ? 'selected' : '' }}>Mới nhất đến mới nhất</option>
                            <option value="asc" {{ request('date_sort') == 'asc' ? 'selected' : '' }}>Cũ nhất đến cũ nhất</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Lọc theo ngày</button>
                    </div>
                    <!-- Giữ lại chude_id nếu có -->
                    @if(request('chude_id'))
                        <input type="hidden" name="chude_id" value="{{ request('chude_id') }}">
                    @endif
                </form>
            </div>
            <div class="col-md-8 text-end">
                <p><a href="{{ route('admin.baiviet.them') }}" class="btn btn-info"><i class="fa-light fas fa-plus"></i> Thêm mới</a></p>
            </div>
        </div>

        <!-- Bảng danh sách bài viết -->
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Chủ đề</th>
                    <th width="55%">Thông tin bài viết</th>
                    <th width="20%" colspan="4" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($baiviet as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->ChuDe->tenchude }}</td>
                    <td>
                        <span class="d-block fw-bold text-primary"><a href="{{ route('admin.baiviet.sua', ['id' => $value->id]) }}">{{ $value->tieude }}</a></span>
                        <span class="d-block small">
                            Ngày đăng: <strong>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y H:i:s') }}</strong>
                            <br />Người đăng: <strong>{{ $value->NguoiDung->name }}</strong>
                            <br />Có <strong>{{ $value->luotxem }}</strong> lượt xem
                            @if($value->file->isNotEmpty())
                                <br />Tệp đính kèm: 
                                <a href="{{ route('tai-tep', $value->file->first()->id) }}" class="text-decoration-none">
                                    <i class="fas fa-file"></i> {{ $value->file->first()->loai_file }}
                                </a>
                            @endif
                        </span>
                    </td>
                    @if(auth()->user()->role === 'admin')
                        <td class="text-center" title="Trạng thái kiểm duyệt">
                            <a href="{{ route('admin.baiviet.kiemduyet', ['id' => $value->id]) }}">
                                @if($value->kiemduyet == 1)
                                <i class="fa-light fa-lg fas fa-circle-check"></i>
                                @else
                                <i class="fa-light fa-lg fas fa-circle-xmark text-danger"></i>
                                @endif
                            </a>
                        </td>
                        <td class="text-center" title="Trạng thái hiển thị">
                            <a href="{{ route('admin.baiviet.kichhoat', ['id' => $value->id]) }}">
                                @if($value->kichhoat == 1)
                                <i class="fa-light fa-lg fas fa-eye"></i>
                                @else
                                <i class="fa-light fa-lg fas fa-eye-slash text-danger"></i>
                                @endif
                            </a>
                        </td>
                    @endif
                    <td class="text-center">
                        <a href="{{ route('admin.baiviet.sua', ['id' => $value->id]) }}">
                            <i class="fa-light fa-lg fas fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.baiviet.xoa', ['id' => $value->id]) }}" onclick="return confirm('Bạn có muốn xóa bài viết {{ $value->tieude }} không?')">
                            <i class="fa-light fa-lg fas fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection