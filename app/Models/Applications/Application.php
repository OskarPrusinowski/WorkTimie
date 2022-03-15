<?php

namespace App\Models\Applications;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'date', 'changed_date', 'comment', 'minutes', 'status', 'accepted', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accepting()
    {
        return $this->belongsToMany(User::class, 'acceptations_users');
    }
}
