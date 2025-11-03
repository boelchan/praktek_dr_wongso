<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function penerima()
    {
        return $this->belongsTo(Penerima::class);
    }

    public static function total_tahun($penerima_id = null)
    {
        return self::whereYear('tanggal', now()->year)
            ->when($penerima_id, fn ($q) => $q->where('penerima_id', $penerima_id))
            ->sum('nominal');
    }

    public static function total_bulan($penerima_id = null)
    {
        return self::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->when($penerima_id, fn ($q) => $q->where('penerima_id', $penerima_id))
            ->sum('nominal');
    }

    public static function total_bulan_lalu($penerima_id = null)
    {
        $month = now()->month;
        $year = now()->year;
        if ($month == 1) {
            $month = 12;
            $year = $year - 1;
        } else {
            $month = $month - 1;
        }

        return self::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->when($penerima_id, fn ($q) => $q->where('penerima_id', $penerima_id))
            ->sum('nominal');
    }

    public static function total_hari()
    {
        return self::whereDate('tanggal', now()->toDateString())->sum('nominal');
    }
}
