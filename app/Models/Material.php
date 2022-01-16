<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuids;


class Material extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Uuids;
    protected $table = "bt_material"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['name', 'quantity', 'damagePrice', 'rentPrice'];
    protected $primaryKey = "material_id";
}
