<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cashier\Models\SellerCommission;
use App\Modules\Goals\Support\GetCurrentGoals;
use App\Modules\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class UserController
 * @package App\Modules\Users\Controllers
 */
class UserController extends Controller
{

    /**
     * @var JWTAuth
     */
    protected $jwt;

    protected $model;
    public $goals;

    /**
     * LoginController constructor.
     * @param JWTAuth $jwt
     */
    public function __construct(JWTAuth $jwt, User $model, GetCurrentGoals $goals)
    {
        $this->jwt = $jwt;
        $this->goals = $goals;
        $this->model = $model;
    }

    public function index()
    {
        try {
            $users = $this->model->whereHas('roles', function ($q) {
                $q->where('roles_id', '!=', 3);
            })->with('roles')->get();

            return response($users, 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }
    }


    public function store(Request $request)
    {
        try {

            $usr = $this->model->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);


            $usr->roles()->attach($request->input('role'));

            $url = env('APP_URL');

            Mail::send('mail.welcome', ['pass' => $request->input('password'), 'user' => $usr, 'url' => $url], function ($m) use ($usr) {
                $m->to($usr->email, $usr->name)->subject('Damiipratii - Boas Vindas');
            });

            return response($usr, 200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            if(Auth::user()->id == $id) {
                return response(['error' => 'Você não pode excluir a si mesmo!'], 500);
            }
            $this->model->find($id)->delete();
            return response(['message' => 'success'], 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->model->where('id',$id)->with('roles')->first();
            return response($user, 200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->model->find($id);
            if($request->has('name')) {
                $user->name = $request->input('name');
            }
            if($request->has('email')) {
                $user->email = $request->input('email');
            }
            if($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            if($request->has('role')) {

                $user->roles()->detach();
                $user->roles()->attach($request->input('role'));
            }

            $user->save();
            return response($user, 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    public function profileUpdate(Request $request)
    {
        try {
            $user = $this->model->find(Auth::id());

            $file = $request->file('file');
            $fileName = 'item-'.$user->id.'-'.date('dmYHis').rand(1,999).'.'.$file->getClientOriginalExtension();
            move_uploaded_file($file, 'drive/avatars/'. $fileName);
            $user->avatar = $fileName;
            $user->save();

            $user->save();
            return response($user, 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }


    /**
     * @param array $infos
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function createUserFromProvider(array $infos)
    {
        try {

            $user = User::create($infos);
            $token = $this->jwt->fromUser($user);
            return response()->json(compact('token'));

        } catch (\Exception $ex) {

            return response($ex->getMessage(),500);

        }
    }

    /**
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function profile()
    {
        try {
            return response(Auth::user(),200);
        } catch (AuthorizationException $ex) {
            return response('Usuário não autorizado.' . $ex->getMessage(), $ex->getCode());
        } catch (AuthenticationException $ex) {
            return response('Usuário não autenticado.' . $ex->getMessage(), $ex->getCode());
        } catch (\Exception $ex) {
            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function getUserRole($roleId)
    {
        try {
            $users = User::whereHas('roles', function ($q) use ($roleId) {
                $q->where('roles_id', '=', $roleId);
            })->with('roles')->get();
            return response($users,200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function current()
    {
        try {
            return response(Auth::user(),200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function currentGoals()
    {
        try {

            return response([
                'commissions' => $this->goals->getSellerCurrentCommissions(Auth::id()),
                'goal_seller' => $this->goals->getGoalSeller(),
                'goal_seller_now' => $this->goals->getGoalSellerNow(Auth::id())[0]->totalSellers,
                'goal_store' => $this->goals->getGoalStore(),
                'goal_store_now' => $this->goals->getGoalStoreNow()[0]->totalStore
            ],200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

}