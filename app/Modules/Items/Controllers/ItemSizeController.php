<?php
/**
 * Created by PhpStorm.
 * User: Alisson
 * Date: 21/11/2017
 * Time: 22:48
 */

namespace App\Modules\Items\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Items\Models\ItemSize;
use Illuminate\Http\Request;

class ItemSizeController extends Controller
{

    protected $model;

    public function __construct(ItemSize $model)
    {
        $this->model = $model;
    }

    public function store(Request $request)
    {
        try {
            $new = $this->model->create($request->all());
            return response($new,200);
        } catch (\Exception $ex) {
            response($ex->getMessage(),500);
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $this->model->find($id)->update($request->all());
            return response(['message' => 'success'],200);
        } catch (\Exception $ex) {
            response($ex->getMessage(),500);
        }

    }

    public function delete($id)
    {
        try {
            $this->model->find($id)->delete();
            return response('deleted',200);
        } catch (\Exception $ex) {
            response($ex->getMessage(),500);
        }
    }

}