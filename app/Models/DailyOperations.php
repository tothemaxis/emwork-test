<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOperations extends Model
{
    use HasFactory;
    protected $table = 'daily_operations';
    protected $fillable = [
        'name',
        'work_type',
        'start_time',
        'end_time',
        'status',
        'created_at',
        'updated_at',
    ];
}
