<?php

namespace App\Modules\Cashier\Models;


use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class SellerCommission extends Model
{

    protected $table = 'seller_commissions';
    protected $fillable = ['users_id','cashiers_id','commission'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class, 'cashiers_id');
    }

}