<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internal_cre_account extends Model
{
    use HasFactory;
    protected $fillable = [
    	'name',
    	'staff_id',
    	'role_id',
    	'gender',
    	'dob',
    	'email',
    	'address',
    	'phone',
    	'username',
    	'password',
    	'remarks',
    	'image'
    ];
    
    public $timestamps = false;
    protected $table = 'users';
}
