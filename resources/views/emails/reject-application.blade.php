@component('mail::message')

<h3>Dear {{ $details['full_name'] }},</h3>
<p>Thank you for taking the time to consider Alita Infotech. 
    We wanted to let you know that we have chosen to move forward with a different candidate for the {{ $details['job_title'] }} position.</p>
<p>Our team was impressed by your skills and accomplishments.We think you could be a good fit for other future openings and will reach out again if we find a good match.</p>
<p>We wish you all the best in your job search and future professional endeavors.</p>
<p>Reason for rejection</p>
<p> {{ $details['reason'] }}</p>
Thanks,<br>
{{ 'Alita Infotech' }}
@endcomponent
