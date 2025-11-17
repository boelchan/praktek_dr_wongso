<div x-data="{ open: true }">
    <!-- Bar atas -->
    <div class="flex justify-between">
        <div class="flex gap-2">
            <!-- Tombol Filter -->
            <button 
                type="button"
                @click="open = !open"
                class="btn btn-soft btn-primary w-10 h-10 lg:w-auto">
                <i class="ti ti-filter text-lg"></i>
                <span class="hidden lg:inline">Filter</span>
            </button>

            <!-- Tombol Reset -->
            <button type="button"
                wire:click="resetFilters" class="btn btn-soft btn-secondary w-10 h-10 lg:w-auto">
                <i class="ti ti-refresh text-lg"></i>
                <span class="hidden lg:inline">Reset</span>
            </button>
        </div>

        <!-- Slot tombol tambahan -->
        <div class="flex gap-2">
            {{ $action ?? '' }}
        </div>
    </div>

    <!-- Filter form -->
    <div class="mt-4" x-show="open" x-transition x-ref="filters">
        <div class="mt-2 grid grid-cols-2 gap-4 lg:grid-cols-4 xl:grid-cols-5">
            {{ $slot }}
        </div>
    </div>
</div>
