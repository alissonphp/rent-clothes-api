<?php

namespace App\Modules\Goals\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Goals\Models\Goals;
use Illuminate\Http\Request;

class GoalsController extends Controller
{

    protected $model;

    public function __construct(Goals $model)
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

}