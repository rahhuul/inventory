<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuids;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Uuids;
    protected $table = "bt_user"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $fillable = ['name', 'email','address','created','type','mobile'];
    protected $primaryKey = "id";





    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
