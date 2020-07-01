<?php
use Carbon\Carbon;
?>

@component('mail::message')
# {{$header}}


@foreach($listings as $listing)

@component('mail::panel')

@if ($listing['type'] === 'Want')
<h1>Wanted</h1>
@elseif ($listing['type'] === 'Offer')
<h1>Offer</h1>
@endif
<br>
Wanted: {{$listing['type']}} <br>
Info: {{$listing['information']}} <br>
The Deal: {{$listing['deal']}} <br>
Email: {{$listing['user']['email']}} <br>
Name: {{$listing['user']['name']}} <br>
@endcomponent

@endforeach

@foreach($events as $event)

@component('mail::panel')
<h1>Event</h1>
<br>
Event: {{$event['name']}} <br>
Info: {{$event['information']}} <br>
When: {{$event['when']}} <br>
Contact: {{$event['contact_info']}} <br>
@endcomponent

@endforeach


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
