@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="login-content">
        <div class="login-logo">
            <a href="#">
                <h1>Login</h1>
            </a>
        </div>
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                        {{ Session::get('flash_message') }}
                        {{ Session::forget('flash_message') }}
                    </div>
                @endif
                <div class="form-group">
                    <label>Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="form-group">
                    <label>Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="login-checkbox">
                    <label>
                       <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                    </label>
                    <label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Forgotten Password?
                            </a>
                        @endif
                    </label>
                </div>
                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>  
            </form>
            <div class="register-link">
                <p>
                    Don't you have account?
                    <a href="{{ route('register') }}" class="text-success">Sign Up Here!</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
