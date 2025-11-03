@props([
    'class' => null,
    'label' => '',
    'model' => '',
    'options' => [],
    'floating' => false,
    'live' => false,
    'change' => false,
    'required' => false,
])

@if ($floating)
    <label class="floating-label">
        <select class="select {{ $class }} w-full" id="{{ $model }}" @if($required) required @endif
            @if ($live) 
                wire:model.live="{{ $model }}" 
            @else
                wire:model="{{ $model }}" 
            @endif
            >
            <option value="">Pilih</option>
            @foreach ($options as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <span>{{ $label }}</span>
    </label>
@else
    <fieldset class="fieldset">
        <legend class="fieldset-legend">
            {{ $label }} 
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </legend>

        <select id="{{ $model }}" class="select {{ $class }} w-full"  @if($required) required @endif
            @if ($live) 
                wire:model.live="{{ $model }}"
            @else
                wire:model="{{ $model }}" 
            @endif
            >
            <option value="">Pilih</option>
            @foreach ($options as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-form.error :name="$model" />
    </fieldset>
@endif
