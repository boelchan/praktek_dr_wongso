@props([
    'label' => null,
    'options' => [],
    'model',
    'multiple' => false,
])

@php
    // Konversi array pluck menjadi format [value => key, label => value]
    $normalizedOptions = [];

    foreach ($options as $key => $value) {
        $normalizedOptions[] = [
            'value' => $key,
            'label' => $value,
        ];
    }
@endphp

<fieldset class="fieldset w-full" x-data="selectComponent({
    multiple: {{ $multiple ? 'true' : 'false' }},
    options: {{ json_encode($normalizedOptions) }},
    model: @entangle($model)
})" @click.outside="open = false">

    {{-- Auto Focus Search When Open --}}
    <div x-effect="
        if (open) {
            highlight = 0;
            $nextTick(() => $refs.searchInput.focus());
        }
    "></div>

    {{-- LEGEND --}}
    @if ($label)
        <legend class="fieldset-legend">{{ $label }}</legend>
    @endif

    {{-- REAL SELECT (hidden but synced) --}}
    <select class="select w-full" x-ref="realSelect" :multiple="multiple" style="display:none;">
        <template x-for="opt in options">
            <option :value="opt.value" :selected="isSelected(opt.value)" x-text="opt.label"></option>
        </template>
    </select>

    {{-- DISPLAY (DaisyUI style) --}}
    <div class="select w-full cursor-pointer" @click="toggleOpen()">

        <template x-if="selectedLabels().length === 0">
            <span class="text-gray-400">Pilih…</span>
        </template>

        <template x-for="lbl in selectedLabels()" :key="lbl">
            <span x-text="lbl"></span>
        </template>
    </div>

    {{-- DROPDOWN --}}
    <div class="relative">

        <div x-show="open" x-transition class="absolute w-full bg-base-100 border border-gray-300 rounded shadow-md mt-1 z-50">

            <!-- SEARCH BAR (ATAS) -->
            <div class="border-b border-gray-300 px-3 flex items-center gap-0">
                <i class="ti ti-search text-lg text-gray-500"></i>
                <input x-ref="searchInput" type="text" class="h-9 w-full text-sm outline-hidden px-2" placeholder="Cari ..." x-model="search" @keydown.arrow-down.prevent="moveDown()" @keydown.arrow-up.prevent="moveUp()" @keydown.enter.prevent="selectHighlighted()" />
            </div>

            <!-- DROPDOWN LIST (BAWAH) -->
            <div class="max-h-80 overflow-y-auto py-2 px-4">
                <template x-for="(item, index) in filtered()" :key="item.value">
                    <div class="px-5 py-1 rounded cursor-pointer hover:bg-base-300" :class="highlight == index ? 'bg-base-300 text-black' : ''" @mouseenter="highlight = index" @click="select(item)">
                        <span x-text="item.label" class="text-sm"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>


    <x-form.error :name="$model" />

</fieldset>


{{-- ALPINE LOGIC --}}
<script>
    function selectComponent(cfg) {
        return {
            open: false,
            search: '',
            highlight: 0,
            options: cfg.options,
            model: cfg.model,
            multiple: cfg.multiple,

            toggleOpen() {
                this.open = !this.open;
                if (this.open) {
                    this.search = "";
                    this.highlight = 0;
                }
            },

            filtered() {
                return this.options.filter(o =>
                    o.label.toLowerCase().includes(this.search.toLowerCase())
                )
            },

            isSelected(val) {
                return this.multiple ?
                    this.model.includes(val) :
                    this.model === val
            },

            selectedLabels() {
                if (this.multiple) {
                    return this.options
                        .filter(o => this.model.includes(o.value))
                        .map(o => o.label)
                }
                const found = this.options.find(o => o.value === this.model)
                return found ? [found.label] : []
            },

            select(item) {
                if (this.multiple) {
                    if (!this.model.includes(item.value)) {
                        this.model.push(item.value)
                    }
                } else {
                    this.model = item.value;
                    this.open = false;
                }
            },

            moveDown() {
                if (this.highlight < this.filtered().length - 1) {
                    this.highlight++;
                }
            },

            moveUp() {
                if (this.highlight > 0) {
                    this.highlight--;
                }
            },

            selectHighlighted() {
                const item = this.filtered()[this.highlight];
                if (item) this.select(item);
            }
        }
    }
</script>
