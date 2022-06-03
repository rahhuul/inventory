<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\ModelEventLogger;


class Damage extends Model
{
    use HasFactory,Uuids;
    protected $table = "damage"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['customer_id', 'material_id', 'quantity', 'price'];
    protected $primaryKey = "damage_id";

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
    // public function received(){
    //     return $this->belongsTo(Received::class,'material_id');
    // }
}
