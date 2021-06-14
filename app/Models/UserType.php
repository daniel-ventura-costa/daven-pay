<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'users_type';

    public function user()
    {
        $this->hasMany(User::class, 'user_type_id');
    }
}
