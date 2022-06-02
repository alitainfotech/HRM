@extends('layout.master')
@section('title',"Job Opening")
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
    <li class="breadcrumb-item active" aria-current="page">Job Opening</li>
  </ol>
</nav>
<!-- job_opening_modal -->
<div class="modal fade  bd-example-modal-lg" id="job_opening_modal" tabindex="-1" aria-labelledby="title_job_opening_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_job_opening_modal">Add Job Opening</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST" name="registration"enctype="multipart/form-data" id="job_opening_form">
          @csrf
          <div >
            <input type="hidden" name="id" class="id" value="0">
          </div>
          <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control title" id="title" name="title"  >
          </div>
          <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control description" id="description" name="description" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="number_openings" class="form-label">Number Openings</label>
            <input type="number" class="form-control number_openings" id="number_openings" name="number_openings" min="1" max="10">
          </div>
          <div class="mb-3">
            <label class="form-label" for="icon">Technology Icon</label>
            <input class="form-control" type="file" id="icon" name="icon">
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="fresher" name="fresher">
            <label class="form-check-label" for="checkDefault">
              Opening for fresher
            </label>
          </div>
          <div class="mb-3 row experience">
            <div class="col-md-6">
              <label for="min_experience" class="form-label">Minimum Experience In Month </label>
              <input type="number" class="form-control min_experience col-md-6" id="min_experience" name="min_experience" value="">
            </div>
            <div class="col-md-6">
              <label for="max_experience" class="form-label">Maximum Experience In Month</label>
              <input type="number" class="form-control max_experience col-md-6" id="max_experience" name="max_experience" value="">
            </div>
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="notification" name="notification">
            <label class="form-check-label" for="notification">
              Notify all Employee of the company when add opening 
            </label>
          </div>
          <button class="btn btn-primary submit_value" type="button"></button>
          
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
            <h6 class="card-title col">Job Openings</h6>
            <div class="col-2 ">
              @if(in_array("2", permission()))
                <a  class="btn btn-primary add_job_opening" style="float: right" id="add_job_opening">Add Job opening</a>
              @endif  
            </div>
          </div>
        <div class="table-responsive mt-2">
          <table id="dataTableExample" class="table" >
            <thead>
              <tr>
                <th>Icon</th>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Number of Openings</th>
                <th>Remaining Vacancies</th>
                <th>Minimum Experience</th>
                <th>Maximum Experience</th>
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
 <script src="{{ asset('assets/js/additional-methods.min.js')}}"></script>
  <script src="{{ asset('assets/js/opening.js') }}"></script>
  
@endpush