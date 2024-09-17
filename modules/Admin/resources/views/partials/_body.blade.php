<div id="loading">
    @include('admin::partials._body_loader')
</div>
@include('admin::partials._body_sidebar')
<main class="main-content">
    <div class="position-relative">
        @include('admin::partials._body_header')
        @include('admin::partials.sub-header')
    </div>

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        {{ $slot }}
    </div>

    @include('admin::partials._body_footer')
</main>
@include('admin::partials._scripts')
@include('admin::partials._app_toast')
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="main_form"></div>
            </div>
        </div>
    </div>
</div>
