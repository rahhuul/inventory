<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\ModelEventLogger;


class Material extends Model
{
    use HasFactory,Uuids;
    protected $table = "material"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['name', 'quantity', 'damagePrice', 'rentPrice', 'rentperPrice'];
    protected $primaryKey = "material_id";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // public function received(){
    //     return $this->belongsTo(Received::class,'material_id');
    // }
}
