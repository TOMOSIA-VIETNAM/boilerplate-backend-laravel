<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            --secondary-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #0fb9b1 0%, #2bcbba 100%);
            --warning-gradient: linear-gradient(135deg, #f7b731 0%, #fed330 100%);
            --danger-gradient: linear-gradient(135deg, #eb4d4b 0%, #ff6b6b 100%);
            --sidebar-bg: linear-gradient(180deg, #2d3436 0%, #636e72 100%);
            --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            --cyan-primary: #00d2ff;
            --cyan-secondary: #3a7bd5;
            --cyan-light: #4facfe;
            --cyan-dark: #00f2fe;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem 1.5rem;
            margin: 0.25rem 0;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.4);
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .main-content {
            min-height: 100vh;
            background: transparent;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 20px 20px;
            margin: 0 20px 20px 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }

        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 210, 255, 0.4);
        }

        .btn-success {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(15, 185, 177, 0.3);
        }

        .btn-warning {
            background: var(--warning-gradient);
            box-shadow: 0 4px 15px rgba(247, 183, 49, 0.3);
        }

        .btn-danger {
            background: var(--danger-gradient);
            box-shadow: 0 4px 15px rgba(235, 77, 75, 0.3);
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background: #00d2ff;
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
            border-radius: 8px 8px 0 0;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(0, 210, 255, 0.05);
            transform: scale(1.01);
        }

        .badge {
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }

        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--cyan-primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25);
        }

        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: var(--card-shadow);
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: var(--cyan-primary);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border: none;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #00b8e6 0%, #2e5bb8 100%);
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar slide-in">
                <div class="d-flex flex-column p-4">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-4 mb-md-0 me-md-auto text-white text-decoration-none">
                        <i class="fas fa-cube fa-2x me-3" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <span class="fs-4 fw-bold">Admin Panel</span>
                    </a>
                    <hr class="text-white-50">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                                <i class="fas fa-blog"></i>
                                Blogs
                            </a>
                        </li>
                    </ul>
                    <hr class="text-white-50">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-white p-2 me-3">
                                <i class="fas fa-user" style="color: var(--cyan-primary);"></i>
                            </div>
                            <div>
                                <strong>Admin</strong>
                                <small class="d-block text-white-50">Administrator</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link position-relative" href="#">
                                        <i class="fas fa-bell fa-lg"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            3
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-cog fa-lg"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid py-4">
                    <div class="fade-in">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 