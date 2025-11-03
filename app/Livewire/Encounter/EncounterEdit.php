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

class EncounterEdit extends Component
{
    public $encounter_id;

    public $observation_id;

    public $encounter_date;

    public $patient_id;

    public $condition_keluhan;

    public $observation_sistolic;

    public $observation_diastolic;

    public $specimen;

    public $medication;

    public $encounter_keterangan;

    public function mount(Encounter $encounter)
    {
        $this->encounter_id = $encounter->id;
        $this->encounter_date = $encounter->encounter_date;
        $this->patient_id = $encounter->patient_id;
        $this->encounter_keterangan = $encounter->keterangan;

        $this->condition_keluhan = $encounter->keluhan_utama;

        foreach ($encounter->observation as $key => $value) {
            if ($value->category == 'sistolic') {
                $this->observation_sistolic = $value->value;
            }
            if ($value->category == 'diastolic') {
                $this->observation_diastolic = $value->value;
            }
        }

        $this->specimen = optional($encounter->specimen)->value;
        $this->medication = optional($encounter->medication)->value;
    }

    public function update()
    {
        Encounter::where('id', $this->encounter_id)->update([
            'patient_id' => $this->patient_id,
            'encounter_date' => $this->encounter_date,
            'keterangan' => $this->encounter_keterangan,
        ]);

        if ($this->observation_sistolic) {
            Observation::updateorCreate(
                ['encounter_id' => $this->encounter_id, 'category' => 'sistolic'],
                ['value' => $this->observation_sistolic]
            );
        }

        if ($this->observation_diastolic) {
            Observation::updateorCreate(
                ['encounter_id' => $this->encounter_id, 'category' => 'diastolic'],
                ['value' => $this->observation_diastolic]
            );
        }

        Condition::updateorCreate(
            ['encounter_id' => $this->encounter_id],
            ['value' => $this->condition_keluhan]
        );

        Specimen::updateorCreate(
            ['encounter_id' => $this->encounter_id],
            ['value' => $this->specimen]
        );

        Medication::updateorCreate(
            ['encounter_id' => $this->encounter_id],
            ['value' => $this->medication]
        );

        Toaster::success('Berhasil');

        // return redirect($this->route_redirect);
    }

    public function render()
    {
        return view('livewire.encounter.encounter-edit', ['patients' => Patient::where('status', 'active')->pluck('full_name', 'id')->all()]);
    }
}
