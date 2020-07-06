@extends('layouts.app')

@section('content')
     <profile-component :user_id="{{ auth()->id() }}"></profile-component>
@endsection
