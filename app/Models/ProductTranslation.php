<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model

{
    protected $table = 'product_translations';

    protected $fillable = ['name', 'description', 'short_description'];

    public $timestamps = false;
}
