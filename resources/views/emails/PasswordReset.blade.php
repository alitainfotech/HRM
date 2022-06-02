@component('mail::message')
Your login detals: 
<p>Hey {{ $data['fullname'] }}!</p>
<p>username: <b>{{ $data['email'] }}</b></p>
<p>Password: '{{ $data['password'] }}'</p> 

Thanks,<br>
{{ 'Alita Infotech' }}
@endcomponent
