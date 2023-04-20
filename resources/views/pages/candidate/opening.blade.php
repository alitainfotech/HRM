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
    <style>
        .white-card {
            padding: 12px;
            box-shadow: 0 10px 40px 0 rgba(0,0,0,.2);
        }

        .jon-title {
            font-size: 18px;
            color: #222;
            font-weight: 600;
        }
        .simple-title{
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="logo p-3">
        <img src="{{ asset('/assets/images/logo-black.png') }}" alt="">
    </div>
    <div class="container">
        <section>
            <div class="row">
                @forelse ($job_openings as $item)
                    <div class="col-md-4 col-sm-6 mt-4">
                        <div class="white-card">
                            @php
                                $year = intdiv($item['min_experience'],12);
                                $month = $item['min_experience']%12;
                                $experience= $year.' year '.$month.' month ';  
                            @endphp
                            <h5 class="jon-title">{{ $item->title }}</h5>
                            <p class="simple-title mt-3">{{ $item->number_openings }} Positions</p>
                            <p class="simple-title">{!! mb_strimwidth($item->description, 0, 50, "...") !!}</p>
                            <p class="simple-title">Experience: {{ $experience }}</p>
                            <a class="btn btn-outline-dark" href="{{ route('candidate.apply',encrypt($item->id)) }}">Apply</a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="white-card">
                            <h5>Coming Soon</h5>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</body>
</html>