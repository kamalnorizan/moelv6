@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', Auth::user()->roles->where('id',2)->count()==1 ? $exception->getMessage() : 'Not Found')
{{-- @if ()
{{$exception->getMessage()}}
@endif --}}
