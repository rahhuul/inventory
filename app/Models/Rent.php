<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\ModelEventLogger;


class Rent extends Model
{
    use HasFactory,Uuids;
    protected $table = "rent_material"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = [ 'customer_id', 'category_id', 'material_id', 'quantity', 'ordered_at'];
    protected $primaryKey = "rent_id";

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
