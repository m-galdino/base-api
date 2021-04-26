<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{    
    protected $table = 'user';

    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'username',
        'url_image_profile'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

}
