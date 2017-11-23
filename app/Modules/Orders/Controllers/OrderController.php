<?php

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
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

    public function show($id)
    {
        try {

            $item = $this->model->find($id);
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