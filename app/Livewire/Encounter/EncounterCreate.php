<?php

namespace App\Livewire\Encounter;

use App\Models\Condition;
use App\Models\Encounter;
use App\Models\Medication;
use App\Models\Observation;
use App\Models\Patient;
use App\Models\Specimen;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EncounterCreate extends Component
{
    public $patientId;

    public $encounter_date;

    public $condition_keluhan;

    public $observation_sistolic;

    public $observation_diastolic;

    public $specimen;

    public $medication;

    public $encounter_keterangan;

    public $route_redirect;

    public $riwayat = [];

    public $patients = [];

    public function mount()
    {
        $this->encounter_date = date('Y-m-d');
        $this->patientId = request()->patient_id;

        $this->route_redirect = route('encounter.index');
        if (request()->patient_id) {
            $this->route_redirect = route('patient.show', $this->patientId);
            $this->riwayat = Encounter::with(['condition', 'medication', 'observation', 'specimen'])->where('patient_id', $this->patientId)->limit(5)->orderBy('encounter_date', 'desc')->orderBy('created_at', 'desc')->get();
        }

        $this->patients = Patient::where('status', 'active')->pluck('full_name', 'id')->all();

    }

    public function updatingPatientId($value)
    {
        $this->riwayat = Encounter::with(['condition', 'medication', 'observation', 'specimen'])->where('patient_id', $value)->limit(5)->orderBy('encounter_date', 'desc')->orderBy('created_at', 'desc')->get();

    }

    public function store()
    {
        // dd($this->patientId);

        $this->validate([
            'patientId' => 'required',
        ]);

        $encounter = Encounter::create([
            'patient_id' => $this->patientId,
            'encounter_date' => $this->encounter_date,
            'keterangan' => $this->encounter_keterangan,
        ]);

        if ($this->observation_sistolic) {
            Observation::create([
                'encounter_id' => $encounter->id,
                'category' => 'sistolic',
                'value' => $this->observation_sistolic,
            ]);
        }
        if ($this->observation_diastolic) {
            Observation::create([
                'encounter_id' => $encounter->id,
                'category' => 'diastolic',
                'value' => $this->observation_diastolic,
            ]);
        }
        if ($this->condition_keluhan) {
            Condition::create([
                'encounter_id' => $encounter->id,
                'category' => 'chief-complaint',
                'value' => $this->condition_keluhan,
            ]);
        }
        if ($this->specimen) {
            Specimen::create([
                'encounter_id' => $encounter->id,
                'value' => $this->specimen,
            ]);
        }
        if ($this->medication) {
            Medication::create([
                'encounter_id' => $encounter->id,
                'value' => $this->medication,
            ]);
        }

        Toaster::success('Berhasil');

        return redirect($this->route_redirect);
    }

    public function render()
    {
        return view('livewire.encounter.encounter-create');
    }
}
