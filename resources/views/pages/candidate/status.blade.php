@php
  use App\Candidate;
  // $c_id =  Session::get('c_id');
  $candidate = Candidate::where('c_id', $c_id)->first();  
@endphp 
@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Dashboard</h4>
  </div>
</div>

<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Application detail</h6>
        {{-- job application form --}}
        <div class="row mb-5 mt-5">
            <div class="col-md-3">
                Post:
            </div>
            <div class="col">
                <p>  {{ $candidate->post }}</p>
            </div>    
        </div>
        <div class="row mb-5 mt-5">
            <div class="col-md-3">
                Apply Date:
            </div>
            <div class="col">
               @php
                $date= $candidate->updated_at;
                $d=strtotime($date);
               @endphp
               {{ date("d-m-Y ", $d) }}
            </div>    
        </div>
        <div class="row mb-5 mt-5">
            <div class="col-md-3">
                status:
            </div>
            <div class="col">
                @php
                
                if($candidate->status==0){
                $status="pending";$class="text-info";}
                elseif($candidate->status==1){
                $status="selected";$class="text-success";}
                elseif($candidate->status==2){
                $status="rejected";$class="text-danger";}
                elseif($candidate->status==3){
                $status="reviewed";$class="text-info";}
                @endphp
                <p class="{{ $class }}">{{ $status }}</p>
               
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