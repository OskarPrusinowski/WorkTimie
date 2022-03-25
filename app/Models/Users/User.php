<?php

namespace App\Models\Users;

use App\Models\AdditionalHours\AdditionalHour;
use App\Models\Departments\Department;
use App\Models\Groups\Group;
use App\Models\Leaves\Leave;
use App\Models\Overtimes\Overtime;
use App\Models\Role;
use App\Models\Workdays\Workday;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'date_start_employment',
        'date_stop_employment',
        'counter_holidays',
        'current_counter_holidays',
        'group_id',
        'role_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function additionalHours()
    {
        return $this->hasMany(AdditionalHour::class);
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    public function workdays()
    {
        return $this->hasMany(Workday::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function scopeAdmin($query)
    {
        return $query->where("role_id", 1);
    }

    public function scopeUserName($query, $userName)
    {
        return $query->where('name', 'like', "%" . $userName . "%")->orWhere('surname', 'like', "%" . $userName . "%");
    }

    public function scopeFiltrDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }
}
