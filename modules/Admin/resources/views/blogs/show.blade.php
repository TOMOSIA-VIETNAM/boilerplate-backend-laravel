@extends('admin::layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Blog Details</h1>
        <div>
            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Edit Blog
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Blog Content -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Blog Content</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-3">{{ $blog->title }}</h2>
                    
                    @if($blog->featured_image_url)
                        <div class="mb-4">
                            <img src="{{ $blog->featured_image_url }}" 
                                 alt="Featured Image" 
                                 class="img-fluid rounded">
                        </div>
                    @endif

                    @if($blog->excerpt)
                        <div class="mb-3">
                            <h5>Excerpt:</h5>
                            <p class="text-muted">{{ $blog->excerpt }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h5>Content:</h5>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Information -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Blog Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $blog->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Slug:</strong></td>
                            <td><code>{{ $blog->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($blog->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($blog->status === 'draft')
                                    <span class="badge bg-warning">Draft</span>
                                @else
                                    <span class="badge bg-secondary">Archived</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Author:</strong></td>
                            <td>
                                @if($blog->user)
                                    <span class="badge bg-info">{{ $blog->user->name }}</span>
                                    <br><small class="text-muted">{{ $blog->user->email }}</small>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $blog->created_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $blog->updated_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                        @if($blog->published_at)
                        <tr>
                            <td><strong>Published:</strong></td>
                            <td>{{ $blog->published_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($blog->status === 'draft')
                            <form method="POST" action="{{ route('admin.blogs.publish', $blog->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('Publish this blog?')">
                                    <i class="fas fa-check"></i> Publish Blog
                                </button>
                            </form>
                        @endif
                        
                        @if($blog->status === 'published')
                            <form method="POST" action="{{ route('admin.blogs.archive', $blog->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning w-100" 
                                        onclick="return confirm('Archive this blog?')">
                                    <i class="fas fa-archive"></i> Archive Blog
                                </button>
                            </form>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
                                <i class="fas fa-trash"></i> Delete Blog
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 