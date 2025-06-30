@extends('admin::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Section -->
            <div class="card mb-4">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold mb-2" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fas fa-blog me-2"></i>Blog Management
                    </h2>
                    <p class="text-muted mb-0">Manage and organize your blog content efficiently</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-list me-2"></i>Blogs List
                    </h5>
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Blog
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card" style="background: rgba(0, 210, 255, 0.05); border: 1px solid rgba(0, 210, 255, 0.1);">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
                                        <div class="col-md-4">
                                            <label for="search" class="form-label fw-bold">
                                                <i class="fas fa-search me-1"></i>Search
                                            </label>
                                            <input type="text" class="form-control" id="search" name="search" 
                                                   value="{{ request('search') }}" placeholder="Search by title or content...">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="status" class="form-label fw-bold">
                                                <i class="fas fa-filter me-1"></i>Status
                                            </label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">All Status</option>
                                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="per_page" class="form-label fw-bold">
                                                <i class="fas fa-list-ol me-1"></i>Per Page
                                            </label>
                                            <select class="form-select" id="per_page" name="per_page">
                                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-search me-1"></i>Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>Published</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                <tr class="align-middle">
                                    <td>
                                        <span class="badge rounded-pill" style="background: var(--primary-gradient);">
                                            #{{ $blog->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blogs.show', $blog->id) }}" class="text-decoration-none">
                                            <strong class="text-dark">{{ Str::limit($blog->title, 50) }}</strong>
                                        </a>
                                        @if($blog->excerpt)
                                            <br><small class="text-muted">{{ Str::limit($blog->excerpt, 100) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->user)
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <span class="fw-bold">{{ $blog->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->status === 'published')
                                            <span class="badge rounded-pill" style="background: var(--success-gradient);">
                                                <i class="fas fa-check me-1"></i>Published
                                            </span>
                                        @elseif($blog->status === 'draft')
                                            <span class="badge rounded-pill" style="background: var(--warning-gradient);">
                                                <i class="fas fa-edit me-1"></i>Draft
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">
                                                <i class="fas fa-archive me-1"></i>Archived
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->featured_image_url)
                                            <img src="{{ $blog->featured_image_url }}" 
                                                 alt="Featured Image" 
                                                 class="img-thumbnail rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-muted small">{{ $blog->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted small">{{ $blog->created_at->format('H:i') }}</div>
                                    </td>
                                    <td>
                                        @if($blog->published_at)
                                            <div class="text-success small">{{ $blog->published_at->format('M d, Y') }}</div>
                                            <div class="text-success small">{{ $blog->published_at->format('H:i') }}</div>
                                        @else
                                            <span class="text-muted small">Not published</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blogs.show', $blog->id) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($blog->status === 'draft')
                                                <form method="POST" action="{{ route('admin.blogs.publish', $blog->id) }}" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" 
                                                            title="Publish" onclick="return confirm('Publish this blog?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($blog->status === 'published')
                                                <form method="POST" action="{{ route('admin.blogs.archive', $blog->id) }}" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" 
                                                            title="Archive" onclick="return confirm('Archive this blog?')">
                                                        <i class="fas fa-archive"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        title="Delete" onclick="return confirm('Delete this blog?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>No blogs found</h5>
                                            <p>Start by creating your first blog post</p>
                                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Create First Blog
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($blogs->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $blogs->appends(request()->query())->links() }}
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