<?php

namespace App\Models\AdditionalHours;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class AdditionalHour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['minutes', 'user_id', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->where('date', Carbon::now()->addHour()->format('Y-m-d'));
    }
}
