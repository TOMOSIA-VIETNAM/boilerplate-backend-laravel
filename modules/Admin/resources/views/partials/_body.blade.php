<div id="loading">
    @include('admin::partials._body_loader')
</div>
@include('admin::partials._body_sidebar')
<main class="main-content">
    <div class="position-relative">
        @include('admin::partials._body_header')
    </div>

    <div class="container-fluid content-inner mt-5 py-0">
        <div class="mt-0 px-0">
            @include('admin::layouts.app_flash')
        </div>
        {{ $slot }}
    </div>

    @include('admin::partials._body_footer')
</main>
@include('admin::partials._scripts')
