@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div style="max-width:420px;margin:40px auto;">
    <div class="card">
        <h2 style="font-size:22px;margin-bottom:6px;">Welcome back</h2>
        <p style="font-size:13px;color:#666;margin-bottom:24px;">Sign in to your account</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       style="width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Password</label>
                <input type="password" name="password" required
                       style="width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;">
            </div>

            <div style="margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="font-size:13px;color:#666;">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;padding:11px;">Login</button>
        </form>

        <p style="text-align:center;font-size:13px;margin-top:20px;color:#666;">
            Don't have an account? <a href="{{ route('register') }}" style="color:#e94560;">Register</a>
        </p>
    </div>
</div>

@endsection
