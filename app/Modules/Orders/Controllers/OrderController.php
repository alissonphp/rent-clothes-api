<?php

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderPayment;
use App\Modules\Orders\Support\OrderManager;
use App\Modules\Users\Models\Role;
use App\Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected $model;
    protected $manager;

    public function __construct(Order $model, OrderManager $manager)
    {
        $this->model = $model;
        $this->manager = $manager;
    }

    public function index()
    {
        try {
            $all = $this->model->with('client','user','pays')->get();
            return response($all,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function sellers()
    {
        try {
            $users = User::whereHas('roles', function ($q) {
                $q->where('roles_id', '=', 4);
            })->with('roles')->get();
            return response($users,200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function store(Request $request)
    {
        try {

            $data = [
                'code' => date('Ymd') . rand(9,9999),
                'clients_id' => $request->input('clients_id'),
                'status' => 'Aberta',
                'output' => $request->input('output'),
                'expected_return' => $request->input('expected_return'),
                'subtotal' => $request->input('subtotal'),
                'discount' => $request->input('discount'),
                'payment_method' => $request->input('payment_method'),
                'total' => $request->input('total'),
                'obs' => $request->input('obs'),
                'users_id' => $request->input('users_id'),
            ];

            $order = $this->model->create($data);

            foreach ($request->input('itens') as $item) {
                $order->orderItems()->create([
                   'orders_id' => $order->id,
                   'days' => $item['days'],
                   'subtotal' => $item['subtotal'],
                   'item_sizes_id' => $item['id'],
                ]);
            }

            return response($order,200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function status($id, $status)
    {
        try {
            $this->manager->setOrder($id)->setUser(Auth::user())->setStatus($status);
            return response(['status' => $status],200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function itemSituation($id, $situation)
    {
        try {
            $order = $this->model->find($id);
            $order->items_situation = $situation;
            $order->save();
            return response(['status' => $order->items_situation],200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }


    public function pay(Request $request)
    {

        try {

            $order = $this->model->find($request->input('id'));

            if($request->input('total_pay') > ($request->input('total') - $request->input('paid'))) {
                return response(['error' => 'O valor informado excede o total da OL!'],500);
            }

            $pay = OrderPayment::create([
                'orders_id' => $request->input('id'),
                'value' => $request->input('total_pay'),
                'users_id' => Auth::user()->id
            ]);

            if(($request->input('total_pay') + $request->input('paid')) == $order->total) {
                $this->manager->setOrder($order->id)
                    ->setUser(Auth::user())
                    ->setStatus('Paga (total)')
                    ->registerCash($request->input('total_pay'));
            } else {
                $this->manager->setOrder($order->id)
                    ->setUser(Auth::user())
                    ->setStatus('Paga (parcial)')
                    ->registerCash($request->input('total_pay'));
            }

            return response($pay,200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }

    }

    public function show($id)
    {
        try {

            $item = $this->model->where('id', $id)->with('orderItems', 'client','user','pays')->first();
            return response($item, 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = $this->model->find($id);
            $item->update($request->all());

            return response($item, 200);

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