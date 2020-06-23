@extends('layouts.app')

@section('content')
    <home-component :user="{{ $user }}"></home-component>
@endsection
