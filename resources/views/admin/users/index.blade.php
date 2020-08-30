@extends('layouts.app')

@section('content')
    <manageusers :loggedinuser="{{ $loggedInUser }}"></manageusers>
@endsection
