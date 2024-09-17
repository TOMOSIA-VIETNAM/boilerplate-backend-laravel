@props(['messages'])

@if ($messages)
    @if (is_array($messages))
        <ul {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @else
        <span {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }} role="alert">
            {{ $messages }}
        </span>
    @endif
@endif
