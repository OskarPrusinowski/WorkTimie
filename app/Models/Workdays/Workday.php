<?php

namespace App\Models\Workdays;

use App\Models\WorkPeriods\WorkPeriod;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workday extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['holiday', 'day', 'date', 'start', 'stop', 'breaktime', 'worktime', 'overtime', 'additional_hours', 'default_worktime', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workPeriods()
    {
        return $this->hasMany(WorkPeriod::class);
    }

    public function scopeFiltrByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->where('date', Carbon::now()->addHour()->format('Y-m-d'));
    }

    public function scopeMonth($query, $month)
    {
        $start = (new Carbon($month))->startOfMonth();
        $stop = (new Carbon($month))->endOfMonth();
        return $query->whereBetween('date', [$start, $stop]);
    }

    public function scopeNotUser($query, $userId)
    {
        return $query->where("user_id", '!=', $userId);
    }
}
