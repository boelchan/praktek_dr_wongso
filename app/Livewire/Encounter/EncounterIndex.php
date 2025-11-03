<?php

namespace App\Livewire\Encounter;

use App\Livewire\Traits\WithTableX;
use App\Models\Encounter;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EncounterIndex extends Component
{
    use WithTableX;

    public $search_encounter_date;

    public function delete($id)
    {
        Encounter::where('id', $id)->delete();
        Toaster::success('Berhasil dihapus');
    }

    public function render()
    {
        $data = Encounter::with(['patient', 'condition'])->when($this->search_encounter_date, fn ($q) => $q->whereDate('encounter_date', $this->search_encounter_date));

        return view('livewire.encounter.encounter-index', ['data' => $this->applyTable($data)]);
    }
}
