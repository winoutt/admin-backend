@extends('emails.master')
@section('content')
<p>Hey {{ $user ? $user->first_name : 'there' }},</p>
<p>{{ $content }}</p>
@endsection