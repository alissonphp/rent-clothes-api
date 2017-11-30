<?php

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Support\OrderManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected $model;
    protected $manager;

    public function __construct(Order $model, OrderManager $manager)
    {
        $this->model = $model;
        $this->manager = $manager;
    }

    public function index()
    {
        try {
            $all = $this->model->with('client')->get();
            return response($all,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function store(Request $request)
    {
        try {
            $order = $this->model->create($request->all());
            return response($order,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function status($id, $status)
    {
        try {
            $this->manager->setOrder($id)->setUser(Auth::user())->setStatus($status);
            return response(['status' => $status],200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function pay(Request $request)
    {

    }

    public function show($id)
    {
        try {

            $item = $this->model->find($id)->with('client','orderItems')->first();
            return response($item, 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = $this->model->find($id);
            $item->update($request->all());

            return response($item, 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function delete($id)
    {
        try {
            $this->model->find($id)->delete();
            return response('deleted',200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

}