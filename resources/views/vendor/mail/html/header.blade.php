@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://vesttradesolutions.com/assets/img/logo.png" alt="Logo" height="100px">
@endif
</a>
</td>
</tr>
