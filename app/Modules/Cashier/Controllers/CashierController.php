<?php

namespace App\Modules\Cashier\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cashier\Models\Cashier;
use Illuminate\Http\Request;

class CashierController extends Controller
{

    protected $model;

    public function __construct(Cashier $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        try {
            $all = $this->model->all();
            return response($all,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function filter(Request $request)
    {
        try {
            $query = $this->model->orderBy('created_at','asc')->with(['order','user']);
            $query->whereBetween('created_at',[$request->input('start') . ' 00:00:00', $request->input('end') . ' 23:59:59']);
            $results = $query->get();
            return response($results,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

}