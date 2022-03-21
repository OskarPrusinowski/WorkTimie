<?php

namespace App\Models\Overtimes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Users\User;
use Carbon\Carbon;


class Overtime extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['minutes', 'user_id', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeToday($query)
    {
        return $query->where('date', Carbon::now()->addHour()->format('Y-m-d'));
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where("user_id", $userId);
    }
}
