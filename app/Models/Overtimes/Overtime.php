<?php

namespace App\Models\Overtimes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Users\User;


class Overtime extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['minutes', 'user_id', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
