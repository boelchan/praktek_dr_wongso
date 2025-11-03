<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = ['id'];
    //

    public function encounter()
    {
        return $this->hasMany(Encounter::class, 'patient_id')->orderBy('encounter_date', 'desc')->orderBy('created_at', 'desc');
    }
}
