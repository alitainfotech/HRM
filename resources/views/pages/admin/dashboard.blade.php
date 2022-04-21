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
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Dashboard</h4>
  </div>
</div>
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
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-briefcase fa-4x text-success"></i>
              <div class="text-right text-dark">
                <h2 class="active_openings text-success"></h2>
                <a href="{{ (in_array("1", permission())) ? route('opening.dashboard') : route('admin.dashboard') }}" class="text-dark"><h4>Active Openings</h4></a>
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
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-users fa-4x text-success"></i>
              <div class="text-right text-dark">
                <h2 class="active_users text-success"></h2>
                <a href="{{ (in_array("5", permission())) ? route('user.dashboard') : route('admin.dashboard') }}" class="text-dark"><h4>Active Users</h4></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-users-slash fa-4x text-danger"></i>
                <div class="text-right text-dark">
                  <h2 class="inactive_users text-danger"></h2>
                  <h4>Inactive Users</h4>
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
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-clipboard fa-4x text-info"></i>
              <div class="text-right text-dark">
                <h2 class="pending_applications text-info"></h2>
                <a href="{{ (in_array("17", permission())) ? route('application.pending') : route('admin.dashboard') }}" class="text-dark"><h4>Pending Applications</h4></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-clipboard-question fa-4x text-warning"></i>
                <div class="text-right text-dark">
                  <h2 class="reviewed_applications text-warning"></h2>
                  <h4>Reviewed Applications</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-regular fa-clipboard fa-4x text-danger"></i>
                <div class="text-right text-dark">
                  <h2 class="rejected_applications text-danger"></h2>
                  <a href="{{ (in_array("17", permission())) ? route('application.reject') : route('admin.dashboard') }}" class="text-dark"><h4>Rejected Applications</h4></a>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-clipboard-check fa-4x text-success"></i>
                <div class="text-right text-dark">
                  <h2 class="selected_applications text-success"></h2>
                  <a href="{{ (in_array("17", permission())) ? route('application.select') : route('admin.dashboard') }}" class="text-dark"><h4>Selected Applications</h4></a>
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
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-user-check fa-4x text-success"></i>
              <div class="text-right text-dark">
                <h2 class="active_interviews text-success"></h2>
                <a href="{{ (in_array("21", permission())) ? route('interview.dashboard') : route('admin.dashboard') }}" class="text-dark"><h4>Active Interviews</h4></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-common">
          <div class="card-body">
            <div class="d-flex justify-content-between align-middle">
              <i class="fa-solid fa-user-xmark fa-4x text-danger"></i>
                <div class="text-right text-dark">
                  <h2 class="inactive_interviews text-danger"></h2>
                  <h4 class="title">Inactive Interviews</h4>
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