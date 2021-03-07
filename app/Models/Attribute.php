<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use Translatable;

    protected $guarded = [];


    public $translatedAttributes = ['name'];


    public  function options(){
        return $this->hasMany(Option::class,'attribute_id');
    }
}
