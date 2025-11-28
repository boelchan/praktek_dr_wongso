<?php

namespace App\Livewire;

use App\Models\Encounter;
use Livewire\Component;

class Dashboard extends Component
{
    public $total_bulan;

    public $total_hari;

    public function mount()
    {
        $this->total_bulan = Encounter::total_bulan();
        $this->total_hari = Encounter::total_hari();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
