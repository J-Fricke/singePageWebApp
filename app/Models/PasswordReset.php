<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
    protected $table = 'password_resets';
    protected $fillable = ['email', 'token', 'created_at'];
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'email');
    }
}