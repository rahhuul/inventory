<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\ModelEventLogger;

 
class ReceivedChallan extends Model
{
    use HasFactory,Uuids;
    protected $table = "receive_challan";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = [ 'customer_id', 'received_id', 'rent_id', 'material_id', 'quantity', 'receive_date', 'ordered_date'];
    protected $primaryKey = "receivechallan_id";

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
    public function received()
    {
        return $this->hasMany(Received::class,'received_id');
    }
}
