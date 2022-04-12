@extends('layout.master2')
@section('title',"Register")
@push('style')
<link rel="stylesheet" href=" {{ asset('css/style.css') }}">
@endpush
{{-- main section start --}}
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      {{-- registration card start--}}
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-image: url({{ url('assets/images/background.jpg') }})"></div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2"><img src="{{ asset('assets/images/logo-black.SVG') }}" alt=""></a>
              <h5 class="text-muted fw-normal mb-4">Create a free account.</h5>
              {{-- registration form --}}
              <form class="forms-sample" id="registration" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                  <label for="fullname" class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="fullname"  name="fullname" placeholder="Full Name">
                </div>
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="userEmail" name="email" placeholder="Email">
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="userPassword" name="password" placeholder="Password">
                </div>
                <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="authCheck" name="remember_me">
                  <label class="form-check-label" for="authCheck">
                    Remember me
                  </label>
                </div>
                <div>
                  <button  class="btn btn-primary me-2 mb-2 mb-md-0" type="submit">Sign Up</button>
                </div>
                <a href="{{ route('login') }}" class="d-block mt-3 text-muted">Already a user? Sign in</a>
              </form>
              {{-- registration form end --}}
            </div>
          </div>
        </div>
      </div>
      {{-- register card end --}}
    </div>
  </div>

</div>
@endsection
{{-- main section end --}}
{{-- custom js --}}
@push('custom-scripts')
  <script type="text/javascript">
    var aurl = {!! json_encode(url('/')) !!}
  </script>
  <!-- jquery validationjs -->
  <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('assets/js/register.js')}}"></script>
@endpush
