@php
  use App\Candidate;
  $c_id =  Session::get('c_id');
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
        <h6 class="card-title">Apply for Job</h6>
        {{-- job application form --}}
        @if(isset($err)){
          <div class="alert alert-danger">
            <p>{{ $err }}</p>
          </div>
        }
        @endif
        <form class="forms-sample" method="POST" action="{{ route('candidate.update') }}" name="registration"enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <input type="hidden" class="form-control" id="c_id" name="c_id" value="{{ $c_id }}">
          </div>
          {{-- <div class="mb-3 col-6">
            <label for="country" class="form-label ">country</label>
           
            <select class=" form-control country select2" id="country" name="country"> --}}
           
            
            </select>
          <div class="mb-3 select">
            <label class="form-label">Post</label>
            <select class="js-example-basic-single form-select" data-width="100%" name="post" >
              @foreach ($job_openings as $job_opening)
                <option value="{{ $job_opening['title'] }}">{{ $job_opening['title'] }}({{ $job_opening['number_openings'] }})</option>
              @endforeach
            </select>
            <div class="text-danger">
              @error('post')
                {{$message}}
              @enderror
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="Name" class="form-label">Name</label>
              <input type="text" class="form-control" id="Name" name="name"  >
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" disabled value="{{ $candidate->email }}">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Contact number:</label>
              <input class="form-control mb-4 mb-md-0" name="phone"/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="cv">File upload</label>
              <input class="form-control" type="file" id="cv" name="cv">
            </div>
          </div>
          <div class="mb-3 select">
            <label class="form-label">Technology</label>
              <select class="js-example-basic-multiple form-select" id="technology" name="technology[]" multiple="multiple" style="width: 100%">
                <optgroup label="php">
                    <option value="Laravel">Laravel</option>
                    <option value="Phalcon">Phalcon</option>
                    <option value="CakePHP">CakePHP</option>
                    <option value="FuelPHP">FuelPHP</option>
                    <option value="Slim">Slim</option>
                </optgroup>  
                <optgroup label="js">
                    <option value="ReactJs.">ReactJs.</option>
                    <option value="Angular.">Angular.</option>
                    <option value="Node.js.">Node.js.</option>
                    <option value="Ember.js.">Ember.js.</option>
                    <option value="Backbone.js.">Backbone.js.</option>
                </optgroup> 
                <option value="HTML">HTML</option>
                <option value="css">css</option>
                <option value="javaScript">javaScript</option>
            </select>
            <div class="text-danger">
              @error('technology')
                {{$message}}
              @enderror
            </div>
          </div>
          <div class="mb-3 row">
            <div class="col-md-6">
              <label for="experience_year" class="form-label">Experience In year </label>
              <input type="number" class="form-control experience col-md-6" id="experience_year" name="experience_year" value="00">
            </div>
            <div class="col-md-6">
              <label for="experience_month" class="form-label">Experience In month</label>
              <input type="number" class="form-control experience col-md-6" id="experience_month" name="experience_month" value="00">
            </div>
          </div>
          <input class="btn btn-primary" type="submit" value="Submit">
        </form>
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