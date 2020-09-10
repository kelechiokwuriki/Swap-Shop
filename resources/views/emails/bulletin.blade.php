<?php
use Carbon\Carbon;
?>

@component('mail::message')
# {{$header}}

<h1>Wanted</h1>
@foreach ($wantedListings as $listing)

@component('mail::panel')
Wanted: {{$listing['item']}} <br>
Info: {{$listing['information']}} <br>
The Deal: {{$listing['deal']}} <br>
Email: {{$listing['user']['email']}} <br>
Name: {{$listing['user']['name']}} <br>
@endcomponent

@endforeach


<h1>Offered</h1>
@foreach ($offeredListings as $listing)

@component('mail::panel')
Offered: {{$listing['item']}} <br>
Info: {{$listing['information']}} <br>
The Deal: {{$listing['deal']}} <br>
Email: {{$listing['user']['email']}} <br>
Name: {{$listing['user']['name']}} <br>
@endcomponent

@endforeach


<h1>Events</h1>
@foreach($events as $event)

@component('mail::panel')
<br>
Event: {{$event['name']}} <br>
Info: {{$event['information']}} <br>
When: {{$event['when']}} <br>
Contact: {{$event['contact_info']}} <br>
@endcomponent

@endforeach

<h1>Swap Shop Information</h1>
<pre>{{$swapShopInformation}}</pre>


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


