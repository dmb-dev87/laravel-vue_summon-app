<!-- <html lang="en">

<body>
	
    <p>Dear {{ $contact->name }}</p>
    <p>Please read the following and click the "Response" to answer.</p>

    <p>Message: {{ $summon->message }}</p>
    <p>Location: {{ $location_name }}</p>
    <p>Due Datetime: {{ $due_datetime }}</p>
    <p>
        <a href="{{ url('/api/summons/mail-response', $contact->id) }}">
            Response
        </a>
    </p>
    <p>Thank you</p>
    <p>{{$user->name}}</p>

</body>

</html> -->

@component('mail::message')

Dear $contact->name

Please read the following and click the "Response" to answer.

Message: $summon->message

Location: $location_name

Due Datetime: $due_datetime

@component('mail::button', ['url' => $action_url])
Response
@endcomponent

Thank you

@endcomponent