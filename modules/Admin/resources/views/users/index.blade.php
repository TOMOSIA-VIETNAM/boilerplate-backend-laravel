@extends('admin::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Section -->
            <div class="card mb-4">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold mb-2" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fas fa-users me-2"></i>User Management
                    </h2>
                    <p class="text-muted mb-0">Manage and organize your application users efficiently</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-list me-2"></i>Users List
                    </h5>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create User
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="align-middle">
                                    <td>
                                        <span class="badge rounded-pill" style="background: var(--primary-gradient);">
                                            #{{ $user->id }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->avatar_url)
                                            <img src="{{ $user->avatar_url }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="rounded-circle border" 
                                                 style="width: 40px; height: 40px; object-fit: cover;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="d-none rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        @if($user->department)
                                            <small class="text-muted">
                                                <i class="fas fa-building me-1"></i>{{ $user->department }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $user->email }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>{{ $user->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge rounded-pill" style="background: var(--danger-gradient);">
                                                <i class="fas fa-shield me-1"></i>Admin
                                            </span>
                                        @elseif($user->role === 'manager')
                                            <span class="badge rounded-pill" style="background: var(--warning-gradient);">
                                                <i class="fas fa-user-tie me-1"></i>Manager
                                            </span>
                                        @else
                                            <span class="badge rounded-pill" style="background: var(--primary-gradient);">
                                                <i class="fas fa-user me-1"></i>User
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status === 'active')
                                            <span class="badge rounded-pill" style="background: var(--success-gradient);">
                                                <i class="fas fa-check me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">
                                                <i class="fas fa-pause me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.users.avatar.form', $user->id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Upload Avatar">
                                                <i class="fas fa-upload"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-group .btn {
    margin-right: 2px;
    border-radius: 8px !important;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.table th {
    border-top: none;
    font-weight: 600;
    background: #00d2ff !important;
    color: white !important;
    border-radius: 8px 8px 0 0;
}
.table td {
    vertical-align: middle;
    border-color: rgba(0, 210, 255, 0.1);
}
.table tbody tr:hover {
    background: rgba(0, 210, 255, 0.05) !important;
    transform: scale(1.01);
    transition: all 0.3s ease;
}
.badge {
    font-weight: 500;
}
.alert {
    border-radius: 15px;
    border: none;
}
</style>
@endsection 