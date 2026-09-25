<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    protected $fillable = ['recorded_at', 'weight', 'note'];
}