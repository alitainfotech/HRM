@php
//   dd($data) ; 
@endphp 

@extends('layout.master')

@push('plugin-styles')
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
    <li class="breadcrumb-item active" aria-current="page">Interviews</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Role detail</h6>
        {{-- job application form --}}
        <div class="row mb-5 mt-5">
            <div class="col-md-3">
                Title:
            </div>
            <div class="col">
                <p>  {{ $data['title'] }}</p>
            </div>    
        </div>
        <div class="row mb-5 mt-5">
            <div class="col-md-3">
                Permissions
            </div>
            <div class="col">
               @php
                $p_name=$data['p_id'];
               @endphp
               @foreach ( $p_name as $p_name )
                   <div class="btn btn-primary">{{ $p_name }}</div>
               @endforeach
               {{-- {{ date("d-m-Y ", $d) }} --}}
            </div>    
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  {{-- custom js --}}

<script type="text/javascript">
  var aurl = {!! json_encode(url('/')) !!}
</script>
<!-- jquery validationjs -->
<script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('assets/js/validation.js')}}"></script>
<script>
    FormValidation.init();
</script>

@endpush