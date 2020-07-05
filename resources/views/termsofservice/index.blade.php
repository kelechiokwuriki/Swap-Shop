@extends('layouts.app')

@section('content')
    <terms-of-service :path="'{{ session('path') ?? ''}}'"></terms-of-service>
@endsection
