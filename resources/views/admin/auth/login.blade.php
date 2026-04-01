<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #1a1a2e; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { background: white; border-radius: 10px; padding: 40px; width: 360px; }
        .login-box h2 { font-size: 22px; margin-bottom: 6px; color: #1a1a2e; }
        .login-box p  { font-size: 13px; color: #666; margin-bottom: 28px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #444; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .form-group input:focus { outline: none; border-color: #e94560; }
        .btn { width: 100%; padding: 11px; background: #e94560; color: white; border: none; border-radius: 5px; font-size: 15px; cursor: pointer; margin-top: 8px; }
        .btn:hover { background: #c73652; }
        .error { background: #f8d7da; color: #721c24; padding: 10px 14px; border-radius: 5px; font-size: 13px; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin Login</h2>
    <p>Enter your admin credentials below.</p>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error){{ $error }}@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">Login as Admin</button>
    </form>
</div>
</body>
</html>
