<?php

namespace App\Modules\Items\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Items\Models\Item;
use Illuminate\Http\Request;

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

            $items = $this->model->with('category')->get();
            return response($items,200);

        } catch (\Exception $ex) {

            return response($ex->getMessage(), 500);

        }

    }
    public function store(Request $request)
    {
        try {
            $new = $this->model->create($request->all());
            return response($new,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }
    }
    public function show($id)
    {

        try {
            return response($this->model->find($id)->with('category')->get(),200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }

    }
    public function update() {}

    public function imageUpload(Request $request, $id)
    {
        try {
            $file = $request->file('file');
            $fileName = 'item-'.$id.'-'.date('dmYHis').'.'.$file->getClientOriginalExtension();
            move_uploaded_file($file, storage_path('app/public/images').'/'. $fileName);
            return response($file,200);
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