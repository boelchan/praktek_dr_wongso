<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PatientEdit extends Component
{
    public $id;

    public $nik;

    public $no_rm;

    #[Validate('required')]
    public $full_name;

    #[Validate('required')]
    public $gender;

    #[Validate('required')]
    public $address;

    #[Validate('required|date')]
    public $dob;

    public function mount(Patient $patient)
    {
        $this->id = $patient->id;
        $this->full_name = $patient->full_name;
        $this->gender = $patient->gender;
        $this->dob = $patient->dob;
        $this->address = $patient->address;
        $this->nik = $patient->nik;
        $this->no_rm = $patient->no_rm;
    }

    protected function rules()
    {
        return [
            'nik' => [
                'required',
                Rule::unique('patients', 'nik')->ignore($this->id),
            ],
        ];
    }

    public function update()
    {
        $this->validate();

        $patient = Patient::findOrFail($this->id);
        $patient->update([
            'nik' => $this->nik,
            'no_rm' => $this->no_rm,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'address' => $this->address,
        ]);

        session()->flash('message', 'Data berhasil diupdate.');

        return to_route('patient.index');
    }

    public function render()
    {
        return view('livewire.patient.patient-edit');
    }
}
