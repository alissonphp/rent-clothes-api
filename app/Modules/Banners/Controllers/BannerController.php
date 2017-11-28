<?php

namespace App\Modules\Banners\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Banners\Models\Banners;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    protected $model;

    public function __construct(Banners $model)
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

    public function actives()
    {

        try {

            $items = $this->model->where('active',1)->get();
            return response($items,200);

        } catch (\Exception $ex) {

            return response($ex->getMessage(), 500);

        }

    }


    public function store(Request $request)
    {
        try {
            $file = $request->file('file');
            $fileName = 'banner-'.date('dmYHis').rand(1,999).'.'.$file->getClientOriginalExtension();
            move_uploaded_file($file, 'drive/banners/'. $fileName);
            $new = $this->model->create([
                'file' => $fileName,
                'link' => 'http://',
                'target' => '_self',
                'active' => 0
            ]);
            return response($new,200);
        } catch (\Exception $ex) {
            return response($ex, 500);
        }
    }
    public function show($id)
    {

        try {
            $item = $this->model->find($id);
            return response($item,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }

    }
    public function update(Request $request, $id)
    {
        try {

            $item = $this->model->find($id);
            $item->link = $request->input('link');
            $item->target = $request->input('target');
            $item->active = $request->input('active');
            $item->save();

            return response($item,200);

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