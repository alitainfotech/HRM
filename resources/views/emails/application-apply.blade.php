@component('mail::message')

<p>Hii <b>{{ $data['fullname'] }} ,</b></p>
<p>Thank you for applying for the post of "{{ $data['post'] }}". </p>
<p>To see the status of your application, please <a href="{{ route('login')}}">click here</a> </p>
    
<p>Your user name is <b>{{ $data['user_name'] }}</b></p>
@if ($data['password'] != '')
<p>Your Password is <b>{{ $data['password'] }}</b></p>
@endif

Thanks,<br>
{{ 'Alita Infotech' }}
@endcomponent

