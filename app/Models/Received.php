<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Received extends Model
{
    use HasFactory,Uuids;
    protected $table = "received_material"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['rent_id', 'received_quantity','receive_status','receive_date','damaged_quantity','is_damage','pending_material','is_lose','losed_quantity','material_id','customer_id'];
    protected $primaryKey = "received_id";

    public function rent()
    {
        return $this->belongsTo(Rent::class,'rent_id');
    }

    public function material(){
        return $this->belongsTo(Material::class,'material_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }
}
