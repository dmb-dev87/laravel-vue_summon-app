@component('mail::message')

Dear {{ $contact->name }}

Please read the following and click the "Response" to answer.

Message: {{ $summon->message }}

Location: {{ $location_name }}

Due Datetime: {{ $due_datetime }}

Thank you

@component('mail::button', ['url' => $action_url])
Response
@endcomponent

@endcomponent