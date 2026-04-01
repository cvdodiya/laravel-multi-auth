@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div style="max-width:420px;margin:40px auto;">
    <div class="card">
        <h2 style="font-size:22px;margin-bottom:6px;">Create account</h2>
        <p style="font-size:13px;color:#666;margin-bottom:24px;">Join us and start shopping</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       style="width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       style="width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Password</label>
                <input type="password" name="password" required
                       style="width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       style="width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;padding:11px;">Create Account</button>
        </form>

        <p style="text-align:center;font-size:13px;margin-top:20px;color:#666;">
            Already have an account? <a href="{{ route('login') }}" style="color:#e94560;">Login</a>
        </p>
    </div>
</div>

@endsection
