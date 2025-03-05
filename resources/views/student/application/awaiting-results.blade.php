
@php
$ap = \App\Models\Application::where('user_id', auth()->user()->id)->first();
@endphp
{{ $ap }}
