<?php

namespace App\Modules\Items\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = ['label'];
    public $timestamps = false;

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class,'categorys_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class,'categorys_id');
    }

}