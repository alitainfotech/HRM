@extends('layout.master')
@section('title',"Roles")
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.dashboard') }}">Roles</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ (!is_null($data['role'])) ? 'edit' :'add'}}</li>
  </ol>
</nav>
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
          <div class="row">
            <h6 class="card-title col">{{ (!is_null($data['role'])) ? 'Edit Role' :'Add Role'}}</h6>
          </div>
          <form class="forms-sample" method="POST" name="registration" id="role_form">
            @csrf
            <div >
              <input type="hidden" name="id" class="id" value="{{ (!is_null($data['role'])) ? $data['role']->id :'0'}}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control title" id="title" name="title"  value="{{ (!is_null($data['role'])) ? $data['role']->title :''}}">
            </div>
            <div class="mb-3 check">
              <label for="" class="form-label">Permissions</label>
              <br>
              @foreach ($data['permissions'] as $permission)
              @php 
              $checked='';
              if(!is_null($data['role'])){
                if(in_array($permission->id, $data['p_id']['p_id'])){
                  $checked="checked";
                }
              }
              @endphp
              <div class="form-check form-check-inline">
                <input type="checkbox" value="{{ $permission['id'] }}" name="permission[]" class="form-check-input permission" id="" {{ $checked }} >
                <label class="form-check-label" for="">
                  {{ $permission['name'] }}
                </label>
              </div>
              @endforeach
              <br>
              <br>
              <input type="checkbox" value="" name="" class="form-check-input " id="selectall" >
              <label class="form-check-label" for="selectall">
                Select All
              </label>
            </div>
            <div class="">
              <button class="btn btn-primary submit_value" type="button">{{ (!is_null($data['role'])) ? 'Update' :'Save'}}</button>
              <a href="{{ route('role.dashboard') }}">
                <button class="btn btn-primary"  type="button">Cancle</button>
              </a>
            </div>
          </form>
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
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script type="text/javascript">
    var aurl = {!! json_encode(url('/')) !!}
  </script>
   {{-- custom js --}}
 <!-- jquery validationjs -->
 <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('assets/js/role.js') }}"></script>
  
@endpush