<?php

namespace App\Modules\Banners\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'banners';
    protected $fillable = ['file','link','target','active'];

}