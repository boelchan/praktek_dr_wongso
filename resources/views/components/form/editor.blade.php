@props([
    'label' => '',
    'model' => '',
    'required' => false,
    'class' => '',
])

<fieldset class="fieldset mb-4">
    <legend class="fieldset-legend text-sm text-gray-700 mb-2">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </legend>

    <div
        x-data="{
            value: @entangle($model),
            quill: null
        }"
        x-init="
            quill = new Quill($refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'code-block'],
                        [{ align: [] }],
                        ['clean']
                    ]
                }
            });

            // Set initial value jika sudah ada
            quill.root.innerHTML = value ?? '';

            // update Livewire ketika content berubah
            quill.on('text-change', () => {
                value = quill.root.innerHTML;
            });

            // update editor ketika Livewire mengubah value dari luar
            $watch('value', (html) => {
                if (quill.root.innerHTML !== html) {
                    quill.root.innerHTML = html ?? '';
                }
            });
        "
        class="relative"
    >
        <div x-ref="editor" class="bg-white border rounded-md"></div>
    </div>

    <x-form.error :name="$model" />
</fieldset>
