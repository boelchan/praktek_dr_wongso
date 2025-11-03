<?php

namespace App\Support;

use Illuminate\Support\Str;

class Column
{
    public string $field;

    public array $attributes = [];

    private function __construct(string $field)
    {
        $this->field = $field;
        $this->attributes['field'] = $field;
    }

    public static function add(string $field): self
    {
        return new self($field);
    }

    public function title(string $title): self
    {
        $this->attributes['label'] = $title;

        return $this;
    }

    public function type(string $type): self
    {
        $this->attributes['type'] = $type;

        return $this;
    }

    public static function make(string $label): self
    {
        $col = new self('__custom_'.Str::random(8));
        $col->attributes['label'] = $label;
        $col->attributes['type'] = 'custom';
        $col->attributes['form_excluded'] = true; // jangan muncul di form

        return $col;
    }

    public function rawHtml(string $html): self
    {
        $this->attributes['type'] = 'custom';
        $this->attributes['raw'] = $html;

        return $this;
    }

    public function rules(string $rules): self
    {
        $this->attributes['rules'] = $rules;

        return $this;
    }

    public function searchable(bool $value = true): self
    {
        $this->attributes['searchable'] = $value;

        return $this;
    }

    /**
     * Jadikan kolom ini sortable.
     * Jika diberikan arah (asc/desc), otomatis jadi default sort.
     */
    public function sortable(string|bool $direction = true): self
    {
        $this->attributes['sortable'] = true;

        if (is_string($direction)) {
            $this->attributes['sort_default'] = strtolower($direction) === 'desc' ? 'desc' : 'asc';
        }

        return $this;
    }

    public function options(array $options): self
    {
        $this->attributes['options'] = $options;

        return $this;
    }

    public function show(string $relationColumn): self
    {
        $this->attributes['show'] = $relationColumn;

        return $this;
    }

    /**
     * Konversi ke array final
     */
    public function toArray(): array
    {
        // Default label jika tidak diisi
        if (! isset($this->attributes['label'])) {
            $this->attributes['label'] = Str::title(str_replace('_', ' ', $this->field));
        }

        // Default type jika tidak diisi → text
        if (! isset($this->attributes['type'])) {
            $this->attributes['type'] = 'text';
        }

        return $this->attributes;
    }
}
