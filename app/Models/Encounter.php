<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $guarded = ['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function condition()
    {
        return $this->hasOne(Condition::class, 'encounter_id');
    }

    public function getKeluhanUtamaAttribute()
    {
        return optional($this->condition)->value;
    }

    public function observation()
    {
        return $this->hasMany(Observation::class, 'encounter_id');
    }

    public function medication()
    {
        return $this->hasOne(Medication::class, 'encounter_id');
    }

    public function specimen()
    {
        return $this->hasOne(Specimen::class, 'encounter_id');
    }

    public static function total_bulan()
    {
        return self::whereYear('encounter_date', now()->year)
            ->whereMonth('encounter_date', now()->month)
            ->count();
    }

    public static function total_hari()
    {
        return self::whereDate('encounter_date', now())
            ->count();
    }
}
