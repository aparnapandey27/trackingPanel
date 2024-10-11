@extends('layouts.app')

@section('content')
    <h1>Profile</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <a href="{{ route('user.profile.edit') }}">Edit Profile</a>
@endsection
