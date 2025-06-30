@extends('admin::layouts.app')

@section('title', 'Upload Avatar - ' . $user->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Upload Avatar</h5>
                    <a href="{{ route('admin.users.show', $user->id) }}" 
                       class="btn btn-secondary">
                        Back to User
                    </a>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($user->avatar_url)
                                    <img src="{{ $user->avatar_url }}" 
                                         alt="{{ $user->name }}" 
                                         class="rounded-circle" 
                                         style="width: 80px; height: 80px; object-fit: cover;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="d-none text-danger">
                                        <small>Image failed to load: {{ $user->avatar_url }}</small>
                                    </div>
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-user text-white fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-1">{{ $user->email }}</p>
                                <p class="text-muted small">{{ ucfirst($user->role) }} - {{ $user->department }}</p>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.avatar.upload', $user->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="avatar" class="form-label fw-bold">
                                Select Avatar Image
                            </label>
                            <div class="border-2 border-dashed border-secondary rounded p-5 text-center" 
                                 id="dropZone">
                                <div class="mb-3">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="btn btn-primary">
                                        <i class="fas fa-upload me-2"></i>Choose File
                                    </label>
                                    <input id="avatar" name="avatar" type="file" class="d-none" accept="image/*" required>
                                    <span class="ms-2 text-muted">or drag and drop</span>
                                </div>
                                <p class="text-muted small mb-0">
                                    PNG, JPG, GIF, WEBP up to 2MB
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload Avatar
                            </button>

                            @if($user->avatar)
                                <form action="{{ route('admin.users.avatar.delete', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this avatar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Delete Avatar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('avatar');
    const dropZone = document.getElementById('dropZone');

    // Drag and drop functionality
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-light');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-light');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-light');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            updateFileName(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            updateFileName(file);
        }
    });

    function updateFileName(file) {
        const fileNameElement = document.createElement('div');
        fileNameElement.className = 'mt-3 p-2 bg-light rounded';
        fileNameElement.innerHTML = `
            <i class="fas fa-file-image me-2"></i>
            <strong>${file.name}</strong>
            <small class="text-muted ms-2">(${(file.size / 1024).toFixed(1)} KB)</small>
        `;
        
        // Remove existing file name display
        const existingFileName = dropZone.querySelector('.mt-3');
        if (existingFileName) {
            existingFileName.remove();
        }
        
        dropZone.appendChild(fileNameElement);
    }
});
</script>
@endsection 