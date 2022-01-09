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
    public $timestamps = true;
    public $fillable = ['name', 'reference_name','address','created','type','mobile', 'reference_mobile'];
    protected $primaryKey = "id";
}
