<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $fillable = ['userid', 'activity', 'timestamp'];

    public $timestamps = false;
    protected $table = 'log_activities';
}
