<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    protected $guarded = ['id'];

    public function rekap()
    {
        return $this->hasMany(Rekap::class);
    }

    public function getTotalTahunanAttribute()
    {
        return Rekap::total_tahun($this->id);
    }

    public function getTotalBulananAttribute()
    {
        return Rekap::total_bulan($this->id);
    }

    public function getTotalBulanLaluAttribute()
    {
        return Rekap::total_bulan_lalu($this->id);
    }
}
