<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    
    <title> {{ config('settings.app.company_name') }} - @yield('title')</title>
</head>
<body>
<p>Hi {{ $user->name }},</p>
<p>Reset your password</p>
<p>
    This is your verification code <b>{{ $user->verification_code }}</b>
</p>
</body>
</html>
