
@php
  $user = Auth::user();
  if(!empty($user['image'])){
    $url=url('/assets/images/users/users_profile_photo/'.$user['image']);
  }else {
    $url=url('https://via.placeholder.com/30x30');
  }
@endphp  
@extends('layout.master')

@section('title',"Profile")
@push('plugin-styles')
  <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
@endpush
@section('content')
<div class="row">
  <div class="col-12 grid-margin">
    <div class="">
      <div class="">
        <figure class="overflow-hidden mb-0 d-flex justify-content-center">
          <img class="wd-200 rounded-circle" src="{{ $url }}" alt="profile">          
        </figure>
        <div class="modal fade  bd-example-modal-lg" id="profile_modal" tabindex="-1" aria-labelledby="title_profile_modal" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="title_profile_modal">Add Job Opening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
              </div>
              <div class="modal-body">
                {{-- Edit profile form --}}
                <form class="forms-sample" name="registration" enctype="multipart/form-data" id="profile_form">
                  @csrf
                  <div class="mb-3">
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $user->id }}">
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="Name" class="form-label">Name</label>
                      <input type="text" class="form-control" id="Name" name="name"  value="{{ $user->full_name }}">
                    </div>
                    <div class="col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label class="form-label" for="image">Profile photo</label>
                      <input class="form-control" type="file" id="image" name="image">
                    </div>
                    <div class="col-md-6">
                      <label for="phone" class="form-label">Phone</label>
                      <input type="number" class="form-control" id="phone" name="phone"  value="">
                    </div>
                  </div>
                  <div class="mb-3 select">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control bio" id="bio" cols="" rows="3"> @if(!is_null($user->bio)) {{ $user->bio }} @endif</textarea>
                    <div class="text-danger">
                      @error('bio')
                        {{$message}}
                      @enderror
                    </div>
                  </div>
                  <input class="btn btn-primary submit_value" type="button" value="Submit">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="justify-content-between align-items-center ">
          <div class="text-center mt-2">
            <h4>{{  $user->full_name }}</h4>
          </div>
          <div class="d-none d-md-block ">
            <button class="btn btn-primary btn-icon-text edit_profile">
              <i data-feather="edit" class="btn-icon-prepend edit_profile"></i> Edit profile
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row profile-body">
  <!-- left wrapper start -->
  <div class="d-none d-md-block col-md-12 col-xl-12 left-wrapper">
    <div class="card rounded">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="card-title mb-0">About</h6>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="git-branch" class="icon-sm me-2"></i> <span class="">Update</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View all</span></a>
            </div>
          </div>
        </div>
        @if(!is_null($user->bio))
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Bio:</label>
          <p class="text-muted">{{ $user->bio }}</p>
        </div>
        @endif
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Joined:</label>
          <p class="text-muted">{{ date('F d,Y',strtotime($user->created_at)) }}</p>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
          <p class="text-muted">{{ $user->email }}</p>
        </div>
        @if(!is_null($user->phone))
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
          <p class="text-muted">{{ $user->phone }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
@push('custom-scripts')
<script type="text/javascript">
  var aurl = {!! json_encode(url('/')) !!}
</script>
<script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('assets/js/additional-methods.min.js')}}"></script>
<script src="{{ asset('assets/js/candidateProfile.js') }}"></script>
  
@endpush