@extends('layouts.app')

@section('content')
    <h1>Edit Profile</h1>
    <form action="{{ route('user.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span>Leave blank to keep current password.</span>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit">Update Profile</button>
    </form>
@endsection
