@extends('mail.layout')


@section('content')
    <h4> {!! $mailData['title'] !!}</h4>
    {!! $mailData['body'] !!}
@endsection