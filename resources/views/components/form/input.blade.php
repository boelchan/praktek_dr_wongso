@props([
    'label' => '',
    'type' => 'text',
    'model' => '',
    'class' => '',
    'live' => false, // kalau true → wire:model.live.debounce.500ms
    'required' => false,
])

<fieldset class="fieldset">
    <legend class="fieldset-legend">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </legend>

    <input type="{{ $type }}" 
        @if ($live) 
            wire:model.live.debounce.500ms="{{ $model }}"
        @else
            wire:model="{{ $model }}" 
        @endif 
        id="{{ $model }}" name="{{ $model }}" class="input w-full min-w-0 {{ $class }}" @if ($required) required @endif />

    <x-form.error :name="$model" />
</fieldset>
