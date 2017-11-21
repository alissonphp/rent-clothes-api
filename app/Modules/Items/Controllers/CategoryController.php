<?php

namespace App\Modules\Items\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Items\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        try {
            $cats = $this->model->all();
            return response($cats,200);
        } catch (\Exception $ex){
            return response($ex->getMessage(), 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $new = $this->model->create([
                'label' => $request->input('label')
            ]);

            return response($new, 200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }
    public function show() {}
    public function update() {}
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