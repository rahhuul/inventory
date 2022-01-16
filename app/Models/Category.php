<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuids;


class Category extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Uuids;
    protected $table = "bt_category"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['name'];
    protected $primaryKey = "category_id";
}
