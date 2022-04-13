@extends('layout.master')
@section('title',"Users")
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
  </ol>
</nav>
<!-- user_modal -->
<div class="modal fade  bd-example-modal-lg" id="user_modal" tabindex="-1" aria-labelledby="title_user_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_user_modal">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" name="registration"enctype="multipart/form-data" id="user_form">
          @csrf
          <div >
            <input type="hidden" name="id" class="id" value="0">
          </div>
          <div class="mb-3 select">
            <label class="form-label">Role</label>
            <select class="js-example-basic-single form-select role" data-width="100%" id="role" name="role">
              <option value="0"selected disabled hidden>select role</option>
              @foreach ($data['roles'] as $role)
                <option value="{{ $role['id'] }}" >{{ $role['title'] }}</option>
              @endforeach
            </select>
            <div class="text-danger">
              @error('post')
                {{$message}}
              @enderror
            </div>
          </div>
          <div class="mb-3">
              <label for="full_name" class="form-label">Full Name</label>
              <input type="text" class="form-control full_name" id="full_name" name="fullname"  >
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control email" id="email" name="u_email" >
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control password" id="password" name="password" >
          </div>
          <div class="mb-3 select">
            <label class="form-label">Department</label>
            <select class="js-example-basic-single form-select department" data-width="100%" id="department" name="department">
              <option value="0"selected disabled hidden>select department</option>
              @foreach ($data['departments'] as $department)
                <option value="{{ $department['id'] }}" >{{ $department['name'] }}</option>
              @endforeach
            </select>
            <div class="text-danger">
              @error('post')
                {{$message}}
              @enderror
            </div>
          </div>
          <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <input type="text" class="form-control designation" id="designation" name="designation" >
          </div>
          <button class="btn btn-primary submit_value" type="submit"></button>
          
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
          <div class="row">
            <h6 class="card-title col">Users</h6>
            <div class="col-2 ">
              @if(in_array("6", permission()))
                <a  class="btn btn-primary add_user" style="float: right" id="add_user">Add User</a>
              @endif
              </div>
          </div>
        <div class="table-responsive mt-2">
          <table id="dataTableExample" class="table" >
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Role</th>
                <th>joining date</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  {{-- <script src="{{ asset('assets/js/data-table.js') }}"></script> --}}
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script type="text/javascript">
    var aurl = {!! json_encode(url('/')) !!}
  </script>
   {{-- custom js --}}
 <!-- jquery validationjs -->
 <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('assets/js/adminUser.js') }}"></script>
  
@endpush