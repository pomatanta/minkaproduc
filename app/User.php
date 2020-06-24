<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = "users";
    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable=[	
        'name',	
        'fullname',	
        'email',
        'password',
        'role',
        'telefono',
        'tipo_doc',
        'num_doc',
        'facebook_id',
        'google_id',
        'avatar',
        'nick'
    ];



    protected $guarded=[

    ];
}
