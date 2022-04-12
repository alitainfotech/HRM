@component('mail::message')
New Application
<p>Hii! <b>{{ $data['fullname'] }}</b></p>
<h5>Apply for {{ $data['post'] }}</h5> 

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

