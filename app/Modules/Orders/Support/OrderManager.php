<?php

namespace App\Modules\Orders\Support;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderStatusLog;
use App\Modules\Users\Models\User;

class OrderManager
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

    public function registerCash()
    {

    }

}