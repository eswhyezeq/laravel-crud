@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Nickname</label>
            <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div>
            <label>New Password</label>
            <input type="password" name="password">
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <div>
            <label>Phone No</label>
            <input type="text" name="phone_no" value="{{ old('phone_no', $user->phone_no) }}">
        </div>

        <div>
            <label>City</label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}">
        </div>

        <div>
            <label>Avatar</label>
            <input type="file" name="avatar">
            @if($user->avatar)
                <br>
                <img src="{{ asset('storage/' . $user->avatar) }}" width="100" alt="Avatar">
            @endif
        </div>

        <button type="submit">Update</button>
    </form>

    <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
        @csrf
        <button type="submit" style="color:red;">Delete Account</button>
    </form>
</div>
@endsection
