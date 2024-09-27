@props([
    'size' => 'modal-lg',
    'method' => '',
    'action' => '',
    'title' => '',
    'footer' => '',
])

<div
    {{ $attributes->merge([
        'class' => 'modal fade',
        'aria-labelledby' => "{$attributes->get('id')}-title",
        'tabindex' => '-1',
        'aria-modal' => 'true',
    ]) }}>
    <div class="modal-dialog modal-dialog-scrollable {{ $size }}" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h3 class="modal-title fs-4 fw-bold">{{ $title }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
