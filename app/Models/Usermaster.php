<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Usermaster extends Model
{
   use HasFactory, Uuids;
    
    protected $table = "usermaster"; // table name
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $primaryKey = "id";
    protected $appends = ['fullname'];

    public function getFullnameAttribute(){
        return "{$this->firstname} {$this->_Lastname}";
    }
}
