@extends('layout.master2')
@section('title',"Reset Password")
@push('style')
<link rel="stylesheet" href=" {{ asset('css/style.css') }}">
@endpush
{{-- main section --}}
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      {{-- reset card start --}}
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-image: url({{ url('assets/images/background.jpg') }})">

            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2"><img src="{{ asset('assets/images/logo-black.SVG') }}" alt=""></a>

              {{-- reset form start --}}
              <form class="forms-sample" action="{{ route('password.update') }}" method="post" id="reset">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control"  id="email" name="email" value="{{ old('email', $request->email) }}">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">New Password</label>
                  <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="New Password">
                </div>
                <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="authCheck" name="remember_me">
                  <label class="form-check-label" for="authCheck">
                    Remember me
                  </label>
                </div>
                <div>
                  <button  class="btn btn-primary me-2 mb-2 mb-md-0" type="submit">Update</button>
                </div>
                <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
              </form>
              {{-- reset form end --}}
            </div>
          </div>
        </div>
      </div>
      {{-- reset card end --}}
    </div>
  </div>

</div>
@endsection
{{-- end section --}}
{{-- custom js --}}
@push('custom-scripts')
  <script type="text/javascript">
    var aurl = {!! json_encode(url('/')) !!}
  </script>
  <!-- jquery validationjs -->
  <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('assets/js/reset.js')}}"></script>
@endpush