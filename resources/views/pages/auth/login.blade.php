@extends('layout.master2')
@section('title',"Login")
{{-- main section --}}
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      {{-- login card start --}}
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-image: url({{ url('assets/images/background.jpg') }})">

            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2"><img src="{{ asset('assets/images/logo-black.SVG') }}" alt=""></a>
              <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>

              {{-- error --}}
              @if (!empty($data))
              <div class="alert alert-danger">
                  <p>{{ $data }}</p>
              </div>

              @endif

              {{-- login form start --}}
              <form class="forms-sample" action="{{ route('verify.password') }}" method="post">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="Password">
                </div>
                <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="authCheck" name="remember_me">
                  <label class="form-check-label" for="authCheck">
                    Remember me
                  </label>
                </div>
                <div>
                  <button  class="btn btn-primary me-2 mb-2 mb-md-0" type="submit">Login</button>
                  <p class="d-block mt-3 text-muted">Forgot Your Password? <a href="{{ route('forgot.view') }}">Reset it here!</a></p>
                </div>
                <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
              </form>
              {{-- login form end --}}
            </div>
          </div>
        </div>
      </div>
      {{-- login card end --}}
    </div>
  </div>

</div>
@endsection
{{-- end section --}}