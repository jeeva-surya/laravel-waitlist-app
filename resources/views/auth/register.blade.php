@extends('layouts.app')

@section('content')
<div class="login-wrap">
    <div class="login-content">
        <div class="login-logo">
            <a href="#">
                <h1>Register</h1>
            </a>
        </div>
        <div class="login-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                        {{ Session::get('flash_message') }}
                        {{ Session::forget('flash_message') }}
                    </div>
                @endif
                <div class="form-group">
                    <label>Name</label>                    
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <button class="au-btn au-btn--block au-btn--green m-b-20 mt-1" type="submit">Sign up</button>  
            </form>
            <div class="register-link">
                <p>
                    Already have account?
                    <a href="{{ route('login') }}" class="text-success">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection