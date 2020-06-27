@extends('layouts.app')

@section('content')
    <admin :user="{{ $user }}"></admin>
@endsection
