<?php

namespace App\Modules\Items\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'items';
    protected $fillable = ['label','price','short_description','description','active', 'price_unit'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorys_id');
    }

    public function sizes()
    {
        return $this->hasMany(ItemSize::class,'items_id');
    }
    public function images()
    {
        return $this->hasMany(ItemImage::class,'items_id');
    }


}