@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Update Profile</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nickname" class="form-label">Nickname</label>
            <input type="text" name="nickname" class="form-control" value="{{ old('nickname', $user->nickname) }}">
            @error('nickname') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Profile Picture</label>
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="100" class="d-block mb-2">
            @endif
            <input type="file" name="avatar" class="form-control">
            @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password (optional)</label>
            <input type="password" name="password" class="form-control">
            <input type="password" name="password_confirmation" class="form-control mt-2" placeholder="Confirm Password">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <form action="{{ route('profile.destroy') }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure? This will delete your account.')">Delete Account</button>
    </form>
</div>
@endsection
