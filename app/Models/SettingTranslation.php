<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    protected $table = 'setting_translations';
    protected $fillable = ['value'];
    public $timestamps =false;
}
