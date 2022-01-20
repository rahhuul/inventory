<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuids;


class User extends Authenticatable
{
    use HasFactory,Uuids;
    protected $table = "user"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['name', 'reference_name','address','created','type','mobile', 'reference_mobile'];
    protected $primaryKey = "user_id";
}
