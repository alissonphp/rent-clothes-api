<?php

namespace App\Modules\Items\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Items\Models\Item;

class ItemController extends Controller
{

    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }

    public function index()
    {

        try {

            $items = $this->model->all();
            return response($items,200);

        } catch (\Exception $ex) {

            return response($ex->getMessage(), 500);

        }

    }
    public function store() {}
    public function show() {}
    public function update() {}
    public function delete() {}

}