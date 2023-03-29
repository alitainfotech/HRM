<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive Laravel Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, laravel, theme, front-end, ui kit, web">
    <title>Candidate</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .opening-title{
            background-color: #F1F1F1;
        }
        .opening-title .title{
            text-align: center;
            padding: 80px 0px 80px 0px;
        }
        .row label.error {
            color:#dc3545;
        }
    </style>
</head>
    <body>
        <section>
            <div class="opening-title">
                <div class="title">
                    <h1>{{ $opening->title }}</h1>
                </div>
            </div>  
        </section>
        <section class="mt-2">
            <div class="row p-4">
                @php
                    $year = intdiv($opening->min_experience,12);
                    $month = $opening->min_experience%12;
                    $experience= $year.' year '.$month.' month ';  
                @endphp
                <div class="col-md-6">
                    <h4>Job Description</h4>
                    <p class="simple-title mt-3">{{ $opening->number_openings }} Positions</p>
                    <p class="simple-title">Required Minimum Experience: {{ $experience }}</p>
                    <p>{{ $opening->description }}</p>
                </div>
                <div class="col-md-6">

                    @if (session()->has('message'))
                        <div class="alert alert-{{ session()->get('type') }} alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <form class="forms-sample" action="{{ route('apply.submit') }}" method="POST" enctype="multipart/form-data" id="application_form">
                        @csrf
                        <input type="hidden" class="form-control o_id" id="o_id" name="o_id" value="{{ encrypt($opening->id)}}">
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" pattern="^[A-Za-zÀ-ÿ ,.'-]+$">
                            <div class="text-danger">
                                @error('name')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            <div class="text-danger">
                                @error('email')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label class="form-label">Contact number:</label>
                            <input type="number" class="form-control mb-4 mb-md-0 phone" name="phone" value="{{ old('phone') }}" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" pattern="^[6-9][0-9]{9}$">
                            <div class="text-danger">
                                @error('phone')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label" for="cv">CV upload</label>
                            <input class="form-control" type="file" id="cv" name="cv">
                            <div class="text-danger">
                                @error('cv')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                        </div>
                        <div class="mb-3 select">
                          <label class="form-label">Why Should We Hire You</label>
                          <textarea name="description" class="form-control description" id="description" cols="" rows="1">{{ old('description') }}</textarea>
                          <div class="text-danger">
                            @error('description')
                              {{$message}}
                            @enderror
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <div class="col-md-6">
                            <label for="experience_year" class="form-label">Experience In year </label>
                            <input type="number" class="form-control experience experience_year" id="experience_year" name="experience_year" value="{{ old('experience_year') }}"  min='0' max="99">
                            <div class="text-danger">
                                @error('experience_year')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="experience_month" class="form-label">Experience In month</label>
                            <input type="number" class="form-control experience experience_month" id="experience_month" name="experience_month" value="{{ old('experience_month') }}" min='0'  max="12">
                            <div class="text-danger">
                                @error('experience_month')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                        </div>
                        <input class="btn btn-dark submit_value" type="submit" value="Submit">
                    </form>
                </div>
            </div>  
        </section>

        <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
        <script src="{{ asset('assets/js/additional-methods.min.js')}}"></script>
        <script>
            $(document).ready(function () {

                jQuery.validator.addMethod("full_name", function(value, element) {
                if (/^([a-zA-Z]{2,}\s[a-zA-z]{1,}'?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)/.test(value)) {
                    return true;
                } else {
                    return false;
                };
                }, 'Please enter your full name.');

                $('#application_form').validate({ // initialize the plugin
                    rules: {
                        name: {
                            required: true,
                            full_name: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        phone: {
                            required: true,
                            minlength:10,
                            maxlength:10,
                        },
                        cv: {
                            required: true,
                            extension: "pdf|docx"
                        },
                        description: {
                            required: true,
                        },
                        experience_year: {
                            required: true,
                            maxlength:2,
                        },
                        experience_month: {
                            required: true,
                            maxlength:2,
                        },
                    }
                });

            });
        </script>
    </body>
</html>