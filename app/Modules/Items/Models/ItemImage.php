<?php

namespace App\Modules\Items\Models;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{

    protected $table = 'item_images';
    protected $fillable = ['items_id','file'];
    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class,'items_id');
    }

}