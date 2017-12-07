<?php

namespace App\Modules\Goals\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Goals\Models\Goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        try {
            $all = $this->model->find($id);
            return response($all,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function store(Request $request)
    {
        try {
            $goal = $this->model->create([
                'month' => $request->input('month'),
                'year' => $request->input('year'),
                'goal_seller' => $request->input('goal_seller'),
                'commission_seller' => $request->input('commission_seller'),
                'goal_store' => $request->input('goal_store'),
                'commission_store' => $request->input('commission_store'),
                'users_id' => Auth::user()->id
            ]);
            return response($goal,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $goal = $this->model->find($id)->update(
                [
                    'month' => $request->input('month'),
                    'year' => $request->input('year'),
                    'goal_seller' => $request->input('goal_seller'),
                    'commission_seller' => $request->input('commission_seller'),
                    'goal_store' => $request->input('goal_store'),
                    'commission_store' => $request->input('commission_store'),
                    'users_id' => Auth::user()->id
                ]
            );
            return response([
                'message' => 'success'
            ],200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function delete($id)
    {
        try {
            $this->model->find($id)->delete();
            return response([
                'message' => 'deleted'
            ],200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

}