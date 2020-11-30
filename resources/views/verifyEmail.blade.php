<html lang="en">

<body>
	
<p>Dear {{ $user_name }}</p>
<p>Your account has been created, please activate your account by clicking this link</p>
<p>
    <a href="{{ url('/email-verify', $email_verification_token) }}">
	    {{ url('/email-verify', $email_verification_token) }}
    </a>
</p>

<p>Your Verification Code: {{$verification_code}} </p>

<p>Thanks</p>

</body>

</html> 