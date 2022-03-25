<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationsCounter extends Model
{
    use HasFactory;

    public function scopeYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
