
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   
   <link rel="stylesheet" href="/css/bootstrap.min.css">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="/css/styleLogin.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>{{ __('Login') }} </h3>
			</div>
			<div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                        </div>
						<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="row align-items-center remember">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="position:relative;">
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
					</div>
					<div class="form-group">
                        <button type="submit" class="btn btn-warning float-right">
                                {{ __('Login') }}
                        </button>                
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
