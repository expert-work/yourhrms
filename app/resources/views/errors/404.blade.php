@extends('errors::minimal')

@section('title', __('Not Found'))


@section('code', '404')

@section('message')
    {{'Not Found' }}
@endsection
@section('details')
    <h3>Sorry, the page you are looking for could not be found.</h3>
@endsection
