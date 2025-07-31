@extends('admin::layouts.app')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <h1 class="display-4 fw-bold mb-3" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Welcome to Admin Panel
                </h1>
                <p class="lead text-muted">Manage your application with ease and style</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                        <i class="fas fa-users me-2"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-success">
                        <i class="fas fa-blog me-2"></i>Manage Blogs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">Total Users</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['total_users'] }}</div>
                        <div class="text-success small">
                            <i class="fas fa-arrow-up me-1"></i>12% increase
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: var(--primary-gradient);">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">Active Users</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['active_users'] }}</div>
                        <div class="text-success small">
                            <i class="fas fa-arrow-up me-1"></i>8% increase
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: var(--success-gradient);">
                        <i class="fas fa-user-check fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">New This Month</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['new_users_this_month'] }}</div>
                        <div class="text-info small">
                            <i class="fas fa-calendar me-1"></i>This month
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: var(--secondary-gradient);">
                        <i class="fas fa-user-plus fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">Admin Users</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['admin_users'] }}</div>
                        <div class="text-warning small">
                            <i class="fas fa-shield me-1"></i>Administrators
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: var(--warning-gradient);">
                        <i class="fas fa-user-shield fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">With Avatar</div>
                        <div class="h2 fw-bold mb-0">{{ $usersWithAvatar }}</div>
                        <div class="text-primary small">
                            <i class="fas fa-image me-1"></i>Profile photos
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-image fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">Inactive Users</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['inactive_users'] }}</div>
                        <div class="text-danger small">
                            <i class="fas fa-arrow-down me-1"></i>3% decrease
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: var(--danger-gradient);">
                        <i class="fas fa-user-times fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">Managers</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['manager_users'] }}</div>
                        <div class="text-info small">
                            <i class="fas fa-user-tie me-1"></i>Team leaders
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-user-tie fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small mb-1">New This Week</div>
                        <div class="h2 fw-bold mb-0">{{ $stats['new_users_this_week'] }}</div>
                        <div class="text-success small">
                            <i class="fas fa-calendar-week me-1"></i>This week
                        </div>
                    </div>
                    <div class="rounded-circle p-3" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-calendar-week fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables Row -->
<div class="row">
    <!-- Users by Role Chart -->
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-chart-pie me-2"></i>Users by Role
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($usersByRole as $role => $count)
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center p-3 rounded" style="background: rgba(0, 210, 255, 0.1);">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; background: {{ $role === 'admin' ? 'var(--danger-gradient)' : ($role === 'manager' ? 'var(--warning-gradient)' : 'var(--primary-gradient)') }};">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-capitalize">{{ $role }}</div>
                                <div class="text-muted small">{{ $count }} users</div>
                            </div>
                            <div class="badge rounded-pill" style="background: {{ $role === 'admin' ? 'var(--danger-gradient)' : ($role === 'manager' ? 'var(--warning-gradient)' : 'var(--primary-gradient)') }};">
                                {{ $count }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Users by Status Chart -->
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-chart-bar me-2"></i>Users by Status
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($usersByStatus as $status => $count)
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center p-3 rounded" style="background: rgba(79, 172, 254, 0.1);">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; background: {{ $status === 'active' ? 'var(--success-gradient)' : 'var(--secondary-gradient)' }};">
                                <i class="fas fa-circle text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-capitalize">{{ $status }}</div>
                                <div class="text-muted small">{{ $count }} users</div>
                            </div>
                            <div class="badge rounded-pill" style="background: {{ $status === 'active' ? 'var(--success-gradient)' : 'var(--secondary-gradient)' }};">
                                {{ $count }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-clock me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Latest Users</h6>
                        @if(isset($recentUsers) && count($recentUsers) > 0)
                            @foreach($recentUsers->take(5) as $user)
                            <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: rgba(0, 210, 255, 0.05);">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                                <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No recent users</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">System Status</h6>
                        <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: rgba(67, 233, 123, 0.1);">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold">System Online</div>
                                <div class="text-muted small">All services running smoothly</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: rgba(79, 172, 254, 0.1);">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                <i class="fas fa-database text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold">Database</div>
                                <div class="text-muted small">Connected and optimized</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: rgba(250, 112, 154, 0.1);">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold">Security</div>
                                <div class="text-muted small">All security measures active</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
