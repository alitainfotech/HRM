@extends('layout.master')
@section('title',"Candidate Dashboard")
@php
  $candidate = Auth::user();  
@endphp 
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
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
      <h4 class="mb-3 mb-md-0">Dashboard</h4>
    </div>
</div>
<!-- application_modal -->
<div class="modal fade  bd-example-modal-lg" id="application_modal" tabindex="-1" aria-labelledby="title_application_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title_application_modal">Add Job Opening</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          {{-- job application form --}}
        @if(isset($err)){
            <div class="alert alert-danger">
              <p>{{ $err }}</p>
            </div>
          }
          @endif
          <form class="forms-sample" method="POST" enctype="multipart/form-data" id="application_form">
            @csrf
            <div class="mb-3">
              <input type="hidden" class="form-control id" id="id" name="id" value="0">
            </div>
            <div class="mb-3">
              <input type="hidden" class="form-control o_id" id="o_id" name="o_id" value="0">
            </div>
            <div class="mb-3">
              <input type="hidden" class="form-control" id="c_id" name="c_id" value="{{ $candidate->id }}">
            </div>
            
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="Name" name="name" disabled value="{{ $candidate->full_name }}">
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" disabled value="{{ $candidate->email }}">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Contact number:</label>
                <input type="number" class="form-control mb-4 mb-md-0 phone" name="phone"/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="cv">CV upload</label>
                <input class="form-control" type="file" id="cv" name="cv">
              </div>
            </div>
            <div class="mb-3 select">
              <label class="form-label">Why Should We Hire You</label>
              <textarea name="description" class="form-control description" id="description" cols="" rows="1"></textarea>
              <div class="text-danger">
                @error('description')
                  {{$message}}
                @enderror
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-md-6">
                <label for="experience_year" class="form-label">Experience In year </label>
                <input type="number" class="form-control experience col-md-6 experience_year" id="experience_year" name="experience_year" value="">
              </div>
              <div class="col-md-6">
                <label for="experience_month" class="form-label">Experience In month</label>
                <input type="number" class="form-control experience col-md-6 experience_month" id="experience_month" name="experience_month" value="">
              </div>
            </div>
            <input class="btn btn-primary submit_value" type="button" value="Submit">
          </form>
        </div>
      </div>
    </div>
</div>
<div class="row">
  @foreach ($job_openings as $job_opening )
  @php
 
    
    $year = intdiv($job_opening['min_experience'],12);
    $month = $job_opening['min_experience']%12;
    $experience= $year.' year '.$month.' month ';  
  @endphp
  
  
  
  
  <div class="col-sm-12 col-md-4 col-xl-3 m-1 overlay">
    <div class="card">
      <img src="{{ url('assets/images/openings/technology_icon/'.$job_opening['image']) }}" class="card-img-top overlay-content" alt="..." height="150px">
        <div class="card-body">
          <h5 class="card-title">{{ $job_opening['title'] }}</h5>
          <p class="card-text mb-3">{{ mb_strimwidth($job_opening['description'], 0, 50, "...") }}</p>
          <p class="card-text mb-3">Required Minimum Experience: {{ $experience }}</p>
          @if($job_opening->application->isNotEmpty())
          @foreach ($job_opening->application as $application)
            @if($application->o_id == $job_opening->id && $application->c_id == $candidate->id)
            
            <div class="btn btn-danger disabled mb-2">Already Applied for this job</div>
            @php
            
            if($application->status==0){
            $status="pending";$class="btn-info";}
            elseif($application->status==1){
            $status="reviewed";$class="btn-info";}
            elseif($application->status==2){
            $status="selected";$class="btn-success";}
            elseif($application->status==3){
            $status="rejected";$class="btn-danger";}
            @endphp
            
            <label class="float-left">Status</label>
            <div class="btn mx-2 {{ $class }} ">{{ $status }}</div>
            @endif
          @endforeach
           
          @else
          <a href="#" class="btn btn-primary apply_job" data-id="{{ $job_opening['id'] }}" data-c_id="{{ $candidate->id }}">Apply</a>
          @endif
        </div>
    </div> 
  </div>
       
  @endforeach
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
 <script src="{{ asset('assets/js/additional-methods.min.js')}}"></script>
 <script src="{{ asset('assets/js/candidate.js') }}"></script>
  
@endpush