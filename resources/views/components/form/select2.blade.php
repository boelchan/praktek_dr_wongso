@props([
    'label' => null,
    'options' => [],
    'model',
])

@php
    $normalizedOptions = [];

    foreach ($options as $key => $value) {
        $normalizedOptions[] = [
            'value' => $key,
            'label' => $value,
        ];
    }
@endphp

<fieldset class="fieldset w-full" x-data="selectComponent({
    options: {{ json_encode($normalizedOptions) }},
    model: @entangle($model)
})" @click.outside="open = false">

    <div x-effect="
        if (open) {
            $nextTick(() => {
                $refs.searchInput.focus();

                // AUTO SCROLL ketika dibuka
                if ($refs.optionList) {
                    if (selectedIndex() !== -1) {
                        // scroll ke item selected
                        const el = $refs.optionList.children[selectedIndex()];
                        if (el) el.scrollIntoView({ block: 'nearest' });
                    } else {
                        // scroll ke paling atas
                        $refs.optionList.scrollTop = 0;
                    }
                }
            });
        }
    "></div>

    @if ($label)
        <legend class="fieldset-legend">{{ $label }}</legend>
    @endif


    {{-- SELECT asli --}}
    <select class="select w-full" style="display:none;">
        @foreach ($normalizedOptions as $opt)
            <option value="{{ $opt['value'] }}" @selected($model == $opt['value'])>
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>


    {{-- Tampilan --}}
    <div class="select w-full cursor-pointer" @click="toggleOpen()">
        <template x-if="selectedLabel() === null">
            <span class="text-gray-400">Pilih</span>
        </template>

        <template x-if="selectedLabel() !== null">
            <span x-text="selectedLabel()"></span>
        </template>
    </div>


    {{-- DROPDOWN --}}
    <div class="relative">
        <div x-show="open" x-transition class="absolute w-full bg-base-100 border border-gray-300 rounded shadow-lg z-50">

            {{-- SEARCH --}}
            <div class="border-b border-gray-300 px-3 flex items-center gap-0">
                <i class="ti ti-search text-lg text-gray-500"></i>
                <input x-ref="searchInput" type="text" class="h-9 w-full text-sm outline-hidden px-2" placeholder="Cari ..." x-model="search" />
            </div>

            {{-- LIST --}}
            <div class="max-h-90 overflow-y-auto p-2" x-ref="optionList">
                <template x-for="(item, index) in filtered()" :key="item.value">
                    <div class="flex justify-left items-center px-0.5 py-2 rounded cursor-pointer hover:bg-base-300" @click="select(item)">
                        {{-- ICON CENTANG --}}
                        <div class="w-6 flex justify-center">
                            <template x-if="item.value == model">
                                <i class="ti ti-check text-lg"></i>
                            </template>

                            <template x-if="item.value != model">
                                <span class="inline-block w-4"></span> {{-- placeholder kosong --}}
                            </template>
                        </div>
                        <span x-text="item.label" class="text-sm"></span>

                    </div>
                </template>
            </div>
        </div>
    </div>

    <x-form.error :name="$model" />

</fieldset>


<script>
    function selectComponent(cfg) {
        return {
            open: false,
            search: '',
            model: cfg.model,
            options: cfg.options,

            init() {},

            toggleOpen() {
                this.open = !this.open;
                if (this.open) {
                    this.search = "";
                }
            },

            filtered() {
                return this.options.filter(o =>
                    o.label.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            selectedLabel() {
                const found = this.options.find(o => o.value == this.model);
                return found ? found.label : null;
            },

            selectedIndex() {
                return this.options.findIndex(o => o.value == this.model);
            },

            select(item) {
                this.model = item.value;
                this.open = false;
            }
        }
    }
</script>
