@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Danh sách bình luận của bạn</h3>
    <ul class="list-group">
        @foreach ($binhluans as $binhluan)
            <li class="list-group-item">
                <strong>Bài viết:</strong> <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $binhluan->baiviet->chude->tenchude_slug, 'tieude_slug' => $binhluan->baiviet->tieude_slug]) }}">
                    {{ $binhluan->baiviet->tieude }}
                </a>
                <br>
                <strong>Bình luận:</strong> {{ $binhluan->noidung }}
                <br>
                <small>Trạng thái: {{ $binhluan->kiemduyet ? 'Đã duyệt' : 'Chờ duyệt' }}</small>
            </li>
        @endforeach
    </ul>
</div>
@endsection
