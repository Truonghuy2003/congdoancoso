@extends('layouts.frontend') 
 
@section('title', 'Liên hệ') 
 
@section('content')
	<div class="bg-body-secondary py-0">
		<div class="container d-lg-flex justify-content-between py-2 py-lg-3">
			<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
						<li class="breadcrumb-item">
							<a class="text-nowrap" href="{{ route('frontend.home') }}"><i class="fas fa-home"></i>Trang chủ</a>
						</li>
						<li class="breadcrumb-item text-nowrap active" aria-current="page">Liên hệ</li>
					</ol>
				</nav>
			</div>
			<div class="order-lg-1 pe-lg-4 text-center text-lg-start">
				<h1 class="h3 mb-0">Liên hệ</h1>
			</div>
		</div>
	</div>
	
	<section class="container-fluid pt-grid-gutter">
		<div class="row">
			<div class="col-xl-3 col-sm-6 mb-grid-gutter">
				<a class="card h-100" href="#map" data-scroll>
					<div class="card-body text-center">
						<i class="fas fa-map-pin h3 mt-2 mb-4 text-primary"></i>
						<h3 class="h6 mb-2">Địa chỉ</h3>
						<p class="fs-sm text-muted">18 Ung Văn Khiêm</p>
						<div class="fs-sm text-primary">Xem bản đồ<i class="fas fa-location-arrow align-middle ms-1"></i></div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-sm-6 mb-grid-gutter">
				<div class="card h-100">
					<div class="card-body text-center">
						<i class="fas fa-clock h3 mt-2 mb-4 text-primary"></i>
						<h3 class="h6 mb-3">Giờ làm việc</h3>
						<ul class="list-unstyled fs-sm text-muted mb-0">
							<li>Thứ 2 - Thứ 6: 08:00 AM - 05:00 PM</li>
							<li class="mb-0">Thứ 7 - Chủ Nhật: 10:00 AM - 21:00 PM</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-grid-gutter">
				<div class="card h-100">
					<div class="card-body text-center">
						<i class="fas fa-phone h3 mt-2 mb-4 text-primary"></i>
						<h3 class="h6 mb-3">Điện thoại</h3>
						<ul class="list-unstyled fs-sm mb-0">
							<li>
								<span class="text-muted me-1">Kỹ thuật:</span>
								<a class="nav-link-style" href="tel:+84123456888">+84 0366 652 716</a>
							</li>
							<li class="mb-0">
								<span class="text-muted me-1">Hỗ trợ kỹ thuật:</span>
								<a class="nav-link-style" href="tel:+84123456999">+84 0366 652 716</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-grid-gutter">
				<div class="card h-100">
					<div class="card-body text-center">
						<i class="fas fa-envelope h3 mt-2 mb-4 text-primary"></i>
						<h3 class="h6 mb-3">Địa chỉ email</h3>
						<ul class="list-unstyled fs-sm mb-0">
							<li>
								<span class="text-muted me-1">Kỹ thuật:</span>
								<a class="nav-link-style" href="mailto:vanhuy382003@gmail.com">kythuat@hhperfume.vn</a>
							</li>
							<li class="mb-0">
								<span class="text-muted me-1">Hỗ trợ kỹ thuật:</span>
								<a class="nav-link-style" href="mailto:vanhuy382003@gmail.com">support@hhperfume.vn</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="container-fluid px-0" id="map">
		<div class="row g-0">
			<div class="col-lg-6 iframe-full-height-wrap">
				<iframe class="iframe-full-height" width="600" height="250" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.6272291437463!2d105.4297639758355!3d10.37166106652758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310a731e7546fd7b%3A0x953539cd7673d9e5!2sAn%20Giang%20University!5e0!3m2!1sen!2s!4v1741302977152!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
			<div class="col-lg-6 px-4 px-xl-5 py-5 border-top">
				<h2 class="h4 mb-4">Để lại lời nhắn</h2>
				<form action="{{ url('/contact') }}" method="POST" class="needs-validation mb-3" novalidate>
					@csrf
					<div class="row g-3">
						<div class="col-sm-6">
							<label class="form-label" for="HoVaTen">Họ và tên:&nbsp;<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="HoVaTen" id="HoVaTen" placeholder="Nguyễn Văn A" required />
							<div class="invalid-feedback">Vui lòng nhập họ và tên của bạn!</div>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="Email">Địa chỉ email:&nbsp;<span class="text-danger">*</span></label>
							<input class="form-control" type="email" name="Email" id="Email" placeholder="nguyenvana@email.com" required />
							<div class="invalid-feedback">Địa chỉ email không được bỏ trống!</div>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="DienThoai">Điện thoại:&nbsp;<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="DienThoai" id="DienThoai" placeholder="0123 456 789" required />
							<div class="invalid-feedback">Vui lòng cung cấp số điện thoại hợp lệ!</div>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="ChuDe">Chủ đề:</label>
							<input class="form-control" type="text" name="ChuDe" id="ChuDe" placeholder="Cung cấp tiêu đề ngắn gọn" />
						</div>
						<div class="col-12">
							<label class="form-label" for="NoiDung">Nội dung tin nhắn:&nbsp;<span class="text-danger">*</span></label>
							<textarea class="form-control" name="NoiDung" id="NoiDung" rows="6" placeholder="Hãy mô tả chi tiết yêu cầu của bạn" required></textarea>
							<div class="invalid-feedback">Nội dung tin nhắn không được bỏ trống!</div>
							<button class="btn btn-primary mt-4" type="submit">Gửi tin nhắn</button>
						</div>
					</div>
				</form>				
			</div>
		</div>
	</div>
	
@endsection 