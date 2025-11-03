@props(['title' => null])

<div>
    <h1 class="text-2xl font-medium text-slate-900">{{ $title }}</h1>

    <div class="mt-6">
        {{ $slot }}
    </div>
</div>
