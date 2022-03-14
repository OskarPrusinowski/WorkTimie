<?php

namespace App\Models\Holidays;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name', 'day', 'date'];

    public function scopeMonth($query, $month)
    {
        $start = (new Carbon($month))->startOfMonth();
        $stop = (new Carbon($month))->endOfMonth();
        return $query->whereBetween('date', [$start, $stop]);
    }

    public function scopeYear($query, $year)
    {
        $start = (new Carbon($year))->startOfYear();
        $stop = (new Carbon($year))->endOfYear();
        return $query->whereBetween('date', [$start, $stop]);
    }

    public function scopeAscDate($query)
    {
        return $query->orderBy("date", "asc");
    }
}
