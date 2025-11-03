<?php

namespace App\Livewire\User;

use App\Livewire\Traits\WithTableX;
use App\Models\User;
use Livewire\Component;

class UserIndex extends Component
{
    use WithTableX;

    // search
    public $search_name;

    public $search_email;

    public function mount() {}

    public function render()
    {
        $data = User::when($this->search_name, fn ($q) => $q->where('name', 'like', '%'.$this->search_name.'%'))
            ->when($this->search_email, fn ($q) => $q->where('email', 'like', '%'.$this->search_email.'%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        return view('livewire.user.user-index', [
            'data' => $data,
        ]);
    }
}
