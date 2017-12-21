<?php

namespace App\Modules\Orders\Support;

use App\Modules\Cashier\Models\Cashier;
use App\Modules\Cashier\Models\SellerCommission;
use App\Modules\Goals\Support\GetCurrentGoals;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderStatusLog;
use App\Modules\Users\Models\User;

class OrderManager extends GetCurrentGoals
{
    private $order;
    private $user;

    public function setOrder($id)
    {
        $this->order = Order::find($id);
        return $this;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function setStatus($status)
    {
        try {
            $this->order->status = $status;
            $this->order->save();

            $this->registerStatusLog($status);
            return $this;

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function registerStatusLog($status)
    {
        try {
            OrderStatusLog::create([
                'users_id' => $this->user->id,
                'orders_id' => $this->order->id,
                'status' => $status
            ]);
            return $this;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function registerCash($total,$method)
    {
        try {
            $cashier = Cashier::create([
                'users_id' => $this->user->id,
                'orders_id' => $this->order->id,
                'total' => $total,
                'method' => $method
            ]);
            $this->registerSellerCommission($total,$cashier);
            return $this;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function registerSellerCommission($total, $cashier)
    {
        try {
           $reg = new SellerCommission();
           $reg->users_id = $this->order->users_id;
           $reg->cashiers_id = $cashier->id;
           $reg->commission = $this->calcSellerCommission($total);
           $reg->save();
           return $this;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

}