<?php

namespace App\Modules\Items\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{

    protected $table = 'item_sizes';
    protected $fillable = ['code','size','items_id','available'];
    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class,'items_id');
    }

}