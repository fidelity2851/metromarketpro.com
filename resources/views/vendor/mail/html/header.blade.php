@props(['url'])
<tr>
<td class="header">
<a href="{{ $url . '/en' }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://metrotradeglobal.com/en/assets/img/logo.png" alt="Logo" height="100px">
@endif
</a>
</td>
</tr>
