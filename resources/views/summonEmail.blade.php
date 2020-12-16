<html lang="en">

<body>
	
    <p>Dear {{ $contact->name }}</p>
    <p>Please read the following and click the "Response" to answer.</p>

    <p>{{ $summon->message }}</p>
    <br/>
    <p>Location: {{ $location_name }}</p>
    <br/>
    <p>Due Datetime: {{ $due_datetime }}</p>
    <p>
        <a href="{{ url('/api/summons/mail-response', $contact->id, $summon->id) }}">
            Response
        </a>
    </p>

    <p>Thank you</p>
    <br/>
    <p>{{$user->name}}</p>

</body>

</html> 