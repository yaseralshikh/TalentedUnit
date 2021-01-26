<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta name="viewport" content="width=device-width, initial-scale=1">

	  <!-- Font Awesome -->
	  <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/fontawesome-free/css/all.min.css') }}">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	  <!-- icheck bootstrap -->
	  <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="{{ asset('dashboard_files/dist/css/adminlte.min.css') }}">
	  <!-- Custom style for yaser -->
	  <link rel="stylesheet" href="{{ asset('dashboard_files/dist/css/yaser.css') }}">
	  <!-- Google Font: Source Sans Pro -->
	  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	  <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
	  <style>
			body,html{
				height:100%;
			}
	  </style>
	</head>
	<body class="hold-transition login-page">
		<div class="container h-100">
			<div class="row h-100 justify-content-center align-items-center">
				<div class="col-sm-12">
					<div class="login-box">
						<div class="login-logo">
						<!--<p>{{ config('app.name', 'Laravel') }} <br> Dashboard <b>Admin</b>LTE</p>-->
						</div>
						<!-- /.login-logo -->
						<div class="card">

							<div class="card-body login-card-body">
								<img src="{{ asset('dashboard_files/images/TalentedUnit.png') }}" class="card-img-top w-20 mx-auto d-block" alt="...">
								<p class="login-box-msg h5">@lang('site.dashboard_login')</p>
								
								@if(session()->has('error'))
									<div class="alert alert-danger">
										{{ session()->get('error') }}
									</div>
								@endif

								<form action="{{ route('login') }}" method="POST">
								@csrf
								<div class="input-group mb-3">
									<input type="text" id="idcard" name="idcard" class="form-control @error('idcard') is-invalid @enderror" placeholder="السجل المدني أو البريد الإلكتروني" name="idcard" value="{{ old('idcard') }}" required autocomplete="idcard" autofocus>
									<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-envelope"></span>
									</div>
									</div>
									@error('idcard')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="input-group mb-3">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="كلمة المرور" name="password" required autocomplete="current-password">
									<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
									</div>
									@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="row">
									<div class="col-8">
									<div class="icheck-primary">
										<input type="checkbox" id="remember" name="remember" class="form-check-input"  {{ old('remember') ? 'checked' : '' }}>
										<label for="remember">
										@lang('site.remember_me')
										</label>
									</div>
									</div>
									<!-- /.col -->
									<div class="col-4">
									<button type="submit" class="btn btn-primary btn-block ">@lang('site.login')</button>
									</div>
									<!-- /.col -->
								</div>
								</form>
					
								@if (Route::has('password.request'))
								<a class="btn btn-link" href="{{ route('password.request') }}">
									@lang('site.forget_password')
								</a>
								@endif
					
							</div>
							<!-- /.login-card-body -->
						</div>
					</div>
					<!-- /.login-box -->
				</div>

				{{-- <div class="col-sm-6 bg-white" style="border-left: 3px solid rgb(228, 228, 228);;">
					<div class="image p-5">
						<img src="{{ asset('dashboard_files/images/TalentedUnit.png') }}" class="img img-fluid rounded mx-auto d-block" alt="">
					</div>
				</div> --}}
			</div>
		</div>

	<!-- jQuery -->
	<script src="{{ asset('dashboard_files/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('dashboard_files/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

	</body>
</html>
