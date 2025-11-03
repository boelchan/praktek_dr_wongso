<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Livewire\Component;

class PatientShow extends Component
{
    public $pasien;

    public function mount(Patient $patient)
    {
        $this->pasien = $patient;
    }

    public function render()
    {
        return view('livewire.patient.patient-show');
    }
}
