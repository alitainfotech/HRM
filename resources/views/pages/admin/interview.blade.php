@extends('layout.master')
@section('title',"Interview")

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
    <li class="breadcrumb-item active" aria-current="page">Interviews</li>
  </ol>
</nav>
<!-- interview_modal -->
<div class="modal fade  bd-example-modal-lg" id="interview_modal" tabindex="-1" aria-labelledby="title_interview_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_interview_modal">Add Job Opening</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
      @if(isset($err)){
          <div class="alert alert-danger">
            <p>{{ $err }}</p>
          </div>
        }
        @endif
        <form class="forms-sample" method="POST" name="registration" enctype="multipart/form-data" id="interview_form">
          @csrf
          <div class="mb-3">
              <input type="hidden" class="form-control id" id="id" name="id" value="0">
          </div>
          <div class="mb-3">
            <input type="hidden" class="form-control i_id" id="i_id" name="i_id" value="0">
          </div>
          <div class="mb-3">
              <label for="Name" class="form-label">Name</label>
              <input type="text" class="form-control name" id="Name" name="name" disabled value="">
          </div>
          <div class="mb-3 select">
            <label class="form-label">Team Leader</label>
            <select class="js-example-basic-single form-select leader" data-width="100%" name="leader" >
              @if($tls->isEmpty())
                <option selected disabled hidden>please add team leader as user first</option>
              @else
                <option value=""selected disabled hidden>Select Team Leader</option>
                @foreach ($tls as $tl)
                  <option value="{{ $tl['id'] }}">{{ $tl['full_name'] }}</option>
                @endforeach
              @endif
            </select>
            <div class="text-danger">
              @error('leader')
                {{$message}}
              @enderror
            </div>
          </div>
          
          <div class="mb-3">
          <label class="form-label">Date & Time</label>
          <input type="datetime-local" class="form-control mb-4 mb-md-0 date" name="date"/>
          </div>
          <input class="btn btn-primary submit_value" type="button" value="Submit" id="add_interview">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- review_modal -->
<div class="modal fade  bd-example-modal-md" id="review_modal" tabindex="-1" aria-labelledby="title_review_modal" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_review_modal">Add Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
      @if(isset($err)){
          <div class="alert alert-danger">
            <p>{{ $err }}</p>
          </div>
        }
        @endif
        <form class="forms-sample" method="POST" name="registration" enctype="multipart/form-data" id="review_form">
          @csrf
          <div class="mb-3">
            <input type="hidden" class="form-control i_id" id="i_id" name="i_id" value="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Review</label>
            <input type="range" class="form-range" name="review" min="0" max="10" value="0" onchange="updateTextInput(this.value);">
            <input type="text" class="form-control" id="textInput" value="">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control description" id="description" name="description" rows="2"></textarea>
          </div>
          <input class="btn btn-primary submit_review" type="button" value="Submit" id="add_review">
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
            <h6 class="card-title col">Interviews</h6>
          </div>
        <div class="table-responsive mt-2">
          <table id="dataTableExample" class="table" >
            <thead>
              <tr>
                <th>ID</th>
                <th>POST</th>
                <th>Interviewer</th>
                <th>Interviewee </th>
                <th>time & date</th>
                <th>CV</th>
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
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script type="text/javascript">
    var aurl = {!! json_encode(url('/')) !!}
  </script>
   {{-- custom js --}}
 <!-- jquery validationjs -->
 <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('assets/js/interview.js') }}"></script>
  
@endpush