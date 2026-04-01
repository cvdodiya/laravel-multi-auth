<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; color: #333; }
        .sidebar { width: 220px; background: #1a1a2e; min-height: 100vh; position: fixed; top: 0; left: 0; padding: 20px 0; }
        .sidebar-brand { color: #e94560; font-size: 18px; font-weight: bold; padding: 0 20px 20px; border-bottom: 1px solid #2a2a4a; }
        .sidebar a { display: block; color: #aaa; text-decoration: none; padding: 11px 20px; font-size: 14px; transition: all .2s; }
        .sidebar a:hover, .sidebar a.active { background: #2a2a4a; color: white; }
        .main { margin-left: 220px; padding: 30px; }
        .topbar { background: white; border-radius: 8px; padding: 14px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
        .topbar h1 { font-size: 18px; font-weight: 600; }
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error   { background: #f8d7da; color: #721c24; }
        .card { background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 24px; }
        .btn { display: inline-block; padding: 9px 20px; border-radius: 5px; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary   { background: #e94560; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-danger    { background: #dc3545; color: white; }
        .btn-success   { background: #28a745; color: white; }
        .btn-sm { padding: 5px 12px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { background: #f8f9fa; font-weight: 600; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 9px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #e94560; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">⚙ Admin Panel</div>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.products.index') }}">Products</a>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
            <a href="#" onclick="this.closest('form').submit()" style="color:#e94560;">Logout</a>
        </button>
    </form>
</div>

<div class="main">
    <div class="topbar">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <span style="font-size:13px;color:#666;">
            Logged in as <strong>{{ Auth::guard('admin')->user()->name }}</strong>
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>
