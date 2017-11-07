<?php

namespace App\Modules\Items\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'items';

    public function sizes()
    {
        return $this->hasMany(ItemSize::class,'items_id');
    }
    public function images()
    {
        return $this->hasMany(ItemImage::class,'items_id');
    }


}