<?php

namespace App\Modules\Clients\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Clients\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $model;

    public function __construct(Client $model)
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

    public function search($term)
    {
        try {
            $cls = $this->model
                ->where('name','like','%'.$term.'%')
                ->orWhere('cpf','like','%'.$term.'%')
                ->orderBy('name','asc')
                ->get();
            return response($cls,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function store(Request $request)
    {
        try {
            $vrf = $this->model->where('cpf', $request->input('cpf'))
                ->orWhere('email',$request->input('email'))
                ->count();
            if($vrf > 0) {
                return response(['error' => 'CPF ou E-mail já cadastrado!'],500);
            }
            $client = $this->model->create($request->all());
            return response($client,200);
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

            if($request->input('cpf') != $item->cpf) {
                $vrf = $this->model->where('cpf', $request->input('cpf'))->count();
                if($vrf > 0) {
                    return response(['error' => 'CPF já cadastrado!'],500);
                }
            }

            $item->update($request->all());

            return response($item, 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function cep($cep)
    {
        try {
            $consult = file_get_contents('https://viacep.com.br/ws/'.$cep.'/json/');
            return response($consult, 200);

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