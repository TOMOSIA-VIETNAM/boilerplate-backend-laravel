<!DOCTYPE html>
<html>
<head>
    <title>Avatar Display Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .avatar-container { margin: 20px 0; }
        .avatar { width: 200px; height: 200px; object-fit: cover; border: 2px solid #ccc; border-radius: 50%; }
        .debug-info { background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Avatar Display Test</h1>
    
    <div class="debug-info">
        <h3>Debug Information:</h3>
        <p><strong>User:</strong> {{ $user->name }}</p>
        <p><strong>Avatar Field:</strong> {{ $user->avatar ?? 'NULL' }}</p>
        <p><strong>Avatar URL:</strong> {{ $user->avatar_url ?? 'NULL' }}</p>
        <p><strong>File Exists:</strong> 
            @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar ?? ''))
                <span class="success">Yes</span>
            @else
                <span class="error">No</span>
            @endif
        </p>
    </div>
    
    <div class="avatar-container">
        <h3>Avatar Display:</h3>
        @if($user->avatar_url)
            <img src="{{ $user->avatar_url }}" 
                 alt="{{ $user->name }}" 
                 class="avatar"
                 onerror="this.style.display='none'; document.getElementById('error').style.display='block';">
            <div id="error" style="display: none;" class="error">
                <p><strong>Image failed to load!</strong></p>
                <p>URL: {{ $user->avatar_url }}</p>
                <p>Possible issues:</p>
                <ul>
                    <li>Server not running</li>
                    <li>Symbolic link broken</li>
                    <li>File permissions</li>
                    <li>Web server configuration</li>
                </ul>
            </div>
        @else
            <p class="error">No avatar URL available</p>
        @endif
    </div>
    
    <div class="avatar-container">
        <h3>Direct File Test:</h3>
        <p><a href="storage/avatars/3/logo-circle_1750646498_DQQGGEOnaH.png" target="_blank">Direct Link to File</a></p>
        <p><a href="storage/avatars/3/" target="_blank">Directory Listing</a></p>
    </div>
    
    <div class="avatar-container">
        <h3>Storage Test:</h3>
        <p>Storage Path: {{ storage_path('app/public/avatars/3/logo-circle_1750646498_DQQGGEOnaH.png') }}</p>
        <p>Public Path: {{ public_path('storage/avatars/3/logo-circle_1750646498_DQQGGEOnaH.png') }}</p>
    </div>
</body>
</html> 