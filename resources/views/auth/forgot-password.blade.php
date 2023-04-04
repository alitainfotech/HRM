@extends('layout.master2')
@section('title',"Forgot Password")
{{-- main section start --}}
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            {{-- forgot card start --}}
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url({{ asset('assets/images/background.jpg') }})"></div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo d-block mb-2"><img src="{{ asset('assets/images/logo-black.png') }}" alt=""></a>
                        {{-- forgot form start --}}
                        <form class="forms-sample" name="forgot_form" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                            <label for="userEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="userEmail" placeholder="Email" name="email">
                            </div>
                            <button  class="btn btn-primary me-2 mb-2 mb-md-0">Reset</button>
                        </form>
                        {{-- forgot form end --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- forgot form end --}}
        </div>
    </div>

</div>
@endsection
{{-- end section --}}