<?php

namespace App\Models\Holidays;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeSaturday extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'free'];
}
