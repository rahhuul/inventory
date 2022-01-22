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
    public $fillable = ['name', 'category_id', 'quantity', 'damagePrice', 'rentPrice'];
    protected $primaryKey = "material_id";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
