@component('mail::message')
Dear Assistant,

We would like to welcome to join us as an Event Assistant.
<br>

Username: {{ $assistant->username }} <br>
Password: {{ $password }}

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
