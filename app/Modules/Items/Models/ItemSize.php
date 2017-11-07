<?php

namespace App\Modules\Items\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{

    protected $table = 'item_sizes';

    public function item()
    {
        return $this->belongsTo(Item::class,'items_id');
    }

}