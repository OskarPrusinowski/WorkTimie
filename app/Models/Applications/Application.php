<?php

namespace App\Models\Applications;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'date', 'first_date', 'second_date', 'comment', 'minutes', 'status', 'accepted', 'user_id', 'acceptation_comment', 'number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accepting()
    {
        return $this->belongsToMany(User::class, 'acceptations_users');
    }

    public function scopeWaiting($query)
    {
        return $query->where("status", "Oczekiwany");
    }

    public function scopeMonth($query, $month)
    {
        $start = (new Carbon($month))->startOfMonth();
        $stop = (new Carbon($month))->endOfMonth();
        return $query->whereBetween('date', [$start, $stop]);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', 'like', "%" . $status . "%");
    }

    public function scopeUserId($query, $userId)
    {
        return $query->where("user_id", $userId);
    }
}
