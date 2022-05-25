<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\ModelEventLogger;

 
class RentChallan extends Model
{
    use HasFactory,Uuids;
    protected $table = "rent_challan"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = [ 'customer_id', 'rent_id', 'material_id', 'quantity', 'ordered_at'];
    protected $primaryKey = "rentchallan_id";

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
    public function rent()
    {
        return $this->hasMany(Rent::class,'rent_id');
    }
}
