<?php

namespace App\Modules\Dashboards\Controllers;


use App\Modules\Clients\Models\Client;
use App\Modules\Items\Models\Item;
use App\Modules\Orders\Models\Order;

class DashboardsController
{

    public function admin()
    {
        try {

            $items = Item::all()->count();
            $clients = Client::all()->count();
            $orders = Order::all()->count();
            $cancels = Order::where('status','Cancelada')->count();

            return response([
                'items' => $items,
                'clients' => $clients,
                'orders' => $orders,
                'cancels' => $cancels
            ],200);

        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}