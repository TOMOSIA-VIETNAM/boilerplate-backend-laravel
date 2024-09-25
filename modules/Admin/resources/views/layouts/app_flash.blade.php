@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show"
        class="alert alert-left alert-success alert-dismissible fade show" role="alert">
        <span>{!! session('success') !!}</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-bottom alert-danger alert-dismissible fade show " role="alert" x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 6000)" x-show="show">
        <span>{!! session('error') !!}</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
