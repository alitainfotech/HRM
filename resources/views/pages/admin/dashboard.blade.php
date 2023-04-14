@extends('layout.master')
@section('title',"Admin Dashboard")
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
  <link rel="stylesheet" href=" {{ asset('css/admin.css') }}">
@endpush

@section('content')
{{-- <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Dashboard</h4>
  </div>
</div> --}}
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Job Openings</h4>
  </div>
</div>
<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-briefcase fa-4x text-success"></i>
              <div class="text-right text-dark">
                <h3 class="active_openings text-success"></h3>
                <a href="{{ (in_array("1", permission())) ? route('opening.dashboard') : route('admin.dashboard') }}" class="text-dark"><h5>Active Openings</h5></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Users</h4>
  </div>
</div>
<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-users fa-4x text-success"></i>
              <div class="text-right text-dark">
                <h3 class="active_users text-success"></h3>
                <a href="{{ (in_array("5", permission())) ? route('user.dashboard') : route('admin.dashboard') }}" class="text-dark"><h5>Active Users</h5></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-users-slash fa-4x text-danger"></i>
                <div class="text-right text-dark">
                  <h3 class="inactive_users text-danger"></h3>
                  <h5>Inactive Users</h5>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">applications</h4>
  </div>
</div>
<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-clipboard fa-4x text-dark"></i>
              <div class="text-right text-dark">
                <h3 class="total_applicant text-dark"></h3>
                <a href="{{ (in_array("17", permission())) ? route('application.pending') : route('admin.dashboard') }}" class="text-dark"><h5>Total Applicant</h5></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-clipboard fa-4x text-info"></i>
              <div class="text-right text-dark">
                <h3 class="pending_applications text-info"></h3>
                <a href="{{ (in_array("17", permission())) ? route('application.pending') : route('admin.dashboard') }}" class="text-dark"><h5>Pending Applications</h5></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-clipboard-question fa-4x text-warning"></i>
                <div class="text-right text-dark">
                  <h3 class="total_application_review text-warning"></h3>
                  <h5>Total Reviewed Applications</h5>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-regular fa-clipboard fa-4x text-danger"></i>
                <div class="text-right text-dark">
                  <h3 class="rejected_applications text-danger"></h3>
                  <a href="{{ (in_array("17", permission())) ? route('application.reject') : route('admin.dashboard') }}" class="text-dark"><h5>Rejected Applications</h5></a>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-clipboard-check fa-4x text-success"></i>
                <div class="text-right text-dark">
                  <h3 class="selected_applications text-success"></h3>
                  <a href="{{ (in_array("17", permission())) ? route('application.select') : route('admin.dashboard') }}" class="text-dark"><h5>Selected Applications</h5></a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Interviews</h4>
  </div>
</div>
<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-user-check fa-4x text-success"></i>
              <div class="text-right text-dark">
                <h3 class="active_interviews text-success"></h3>
                <a href="{{ (in_array("21", permission())) ? route('interview.dashboard') : route('admin.dashboard') }}" class="text-dark"><h5>Active Interviews</h5></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <i class="fa-solid fa-user-xmark fa-4x text-danger"></i>
                <div class="text-right text-dark">
                  <h3 class="inactive_interviews text-danger"></h3>
                  <h5 class="title">Inactive Interviews</h5>
                </div>
            </div>
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
<script src="{{ asset('assets/js/adminDashboard.js')}}"></script>


@endpush