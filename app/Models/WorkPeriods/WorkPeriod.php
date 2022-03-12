<?php

namespace App\Models\WorkPeriods;

use App\Models\Workdays\Workday;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPeriod extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['type', 'start', 'stop', 'weekday_id'];

    public function workday()
    {
        return $this->belongsTo(Workday::class);
    }

    public function scopeFiltrByWeekday($query, $workdayId)
    {
        return $this->query->where('workdayId', $workdayId);
    }
}
