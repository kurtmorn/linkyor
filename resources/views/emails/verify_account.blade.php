<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

<span>Hey there, <strong>{{ $user->username }}</strong></span>
<br>
<span>Thanks for verifying your account. This'll make your account more secure if you ever get compromised. There's just one more step though; click the link below to link this email with your account.</span>
<br>
<br>
<a href="{{ route('account.verify.confirm', $code) }}">{{ route('account.verify.confirm', $code) }}</a>
<br>
<br>
<span>If this request wasn't by you, then you can just ignore this email.</span>
<br>
<br>
<span>Happy Hilling!</span>
<br>
<span style="color:#888888;">{{ config('site.name') }}</span>
