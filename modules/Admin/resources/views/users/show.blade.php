@extends('admin::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Details</h5>
                    <div>
                        <a href="{{ route('admin.users.avatar.form', $user->id) }}" class="btn btn-info">
                            <i class="fas fa-upload me-2"></i>Upload Avatar
                        </a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">Avatar:</div>
                        <div class="col-md-8">
                            @if($user->avatar_url)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->avatar_url }}" 
                                         alt="{{ $user->name }}" 
                                         class="rounded-circle me-3" 
                                         style="width: 60px; height: 60px; object-fit: cover;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="d-none text-danger">
                                        <small>Image failed to load: {{ $user->avatar_url }}</small>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.users.avatar.form', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Change Avatar
                                        </a>
                                        <form action="{{ route('admin.users.avatar.delete', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline ms-2"
                                              onsubmit="return confirm('Are you sure you want to delete this avatar?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <a href="{{ route('admin.users.avatar.form', $user->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-upload me-1"></i>Upload Avatar
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">ID:</div>
                        <div class="col-md-8">{{ $user->id }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Name:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Role:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Department:</div>
                        <div class="col-md-8">{{ $user->department ?? 'N/A' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $user->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Updated At:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 fw-bold">Last Login:</div>
                        <div class="col-md-8">{{ $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 