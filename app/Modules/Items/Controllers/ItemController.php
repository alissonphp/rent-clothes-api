<?php

namespace App\Modules\Items\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Items\Models\Item;
use App\Modules\Items\Models\ItemImage;
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
            $item = $this->model->where('id', $id)->with('category','sizes')->first();
            return response($item,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }

    }
    public function update(Request $request, $id)
    {
        try {

            $item = $this->model->find($id);
            $item->label = $request->input('label');
            $item->price = $request->input('price');
            $item->short_description = $request->input('short_description');
            $item->description = $request->input('description');
            $item->active = $request->input('active');
            $item->price_unit = $request->input('price_unit');
            $item->categorys_id = $request->input('categorys_id');
            $item->save();

            $get = $this->model->where('id', $id)->with('category','sizes')->first();

            return response($get,200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function imageUpload(Request $request, $id)
    {
        try {
            $file = $request->file('file');
            $fileName = 'item-'.$id.'-'.date('dmYHis').rand(1,999).'.'.$file->getClientOriginalExtension();
            move_uploaded_file($file, storage_path('app/public/images').'/'. $fileName);

            ItemImage::create([
                'items_id' => $id,
                'file' => $fileName
            ]);

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