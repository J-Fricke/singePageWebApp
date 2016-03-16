<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [''];
    protected $hidden = ['created_at', 'updated_at'];

    public function passwordResets()
    {
        return $this->hasMany('App\Models\PasswordReset', 'email');
    }
}