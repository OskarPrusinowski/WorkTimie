<?php

namespace App\Models\Leaves;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start',
        'end',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where("user_id", $userId);
    }
    public function scopeMonth($query, $month)
    {
        $start = (new Carbon($month))->startOfMonth()->format("Y-m-d");
        $stop = (new Carbon($month))->endOfMonth()->format("Y-m-d");
        return $query->whereBetween('start', [$start, $stop])->orWhere('end', '>', $start)->where('end', '<', $stop);
    }
}
