<?php

namespace App\Modules\Orders\Support;


use App\Modules\Items\Models\ItemSize;
use App\Modules\Orders\Models\Order;

class OrderItemsManager
{

    static function out($id)
    {
        try {

            $items = Order::where('id', $id)->first()->orderItems()->get();

            foreach ($items as $i) {
                $size = ItemSize::where('id', $i->item_sizes_id)->first();
                $size->available--;
                $size->save();
            }

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    static function in($id)
    {
        try {

            $items = Order::where('id', $id)->first()->orderItems()->get();

            foreach ($items as $i) {
                $size = ItemSize::where('id', $i->item_sizes_id)->first();
                $size->available++;
                $size->save();
            }

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

}