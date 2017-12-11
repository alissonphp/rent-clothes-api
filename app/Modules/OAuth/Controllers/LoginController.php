<?php

namespace App\Modules\OAuth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Controllers\UserController;
use App\Modules\Users\Models\RememberToken;
use App\Modules\Users\Models\User;
use App\Modules\Users\Supports\MailCheckSupport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite as Socialite;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * Class LoginController
 * @package App\Modules\OAuth\Controllers
 */

class LoginController extends Controller
{

    /**
     * @var JWTAuth
     */
    protected $jwt;
    /**
     * @var UserController
     */
    public $userController;


    /**
     * LoginController constructor.
     * @param JWTAuth $jwt
     * @param UserController $userController
     */
    public function __construct(JWTAuth $jwt, UserController $userController)
    {
        $this->jwt = $jwt;
        $this->userController = $userController;
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
            ->stateless()
            ->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function handleProviderCallback($provider)
    {
        try {

            /**
             * get user infos with callback provider token
             */

            $user = Socialite::driver($provider)
                ->stateless()
                ->user();

            /**
             * check if user email exists in database
             */

            if(!MailCheckSupport::userEmailCheck($user->email)) {

                /**
                 * create user array infos to save in database
                 */

                $userInfos = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => null,
                    'remember_token' => str_random(10),
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'avatar_url' => $user->avatar
                ];

                /**
                 * generate a personal token access from this new user
                 */

                $token = $this->userController->createUserFromProvider($userInfos);

            } else {

                /**
                 * search existent user in database and generate your personal token access
                 */

                $existsUser = User::where('email',$user->email)->first();
                $token = $this->jwt->fromUser($existsUser);

            }

            return response()->json(compact('token'));
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {
            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }

        $user = User::select('name','email','id')->where('email', $request->input('email'))->with('roles')->first();

        return response()->json(compact('token','user'));
    }

    public function remember(Request $request)
    {
        try {
            $user = User::where('email', $request->input('email'))->first();
            if(!$user) {
                return response(['error' => 'Usuário não encontrado'],404);
            }

            $now = Carbon::now();
            $token = RememberToken::create([
               'users_id' => $user->id,
                'token' => md5(random_bytes(10)),
                'expired_at' => $now->addHour()

            ]);
            $url = env('APP_URL');

            Mail::send('mail.remember', ['token' => $token, 'user' => $user, 'url' => $url], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Damiipratii - Redefinição de Senha');
            });

            return response(['message' => 'success'],200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function checkToken(Request $request)
    {
        try {

            $now = Carbon::now();
            $token = RememberToken::where('token', $request->input('token'))->first();
            if(!$token) {
                return response(['error' => 'Token inválido'],404);
            }

            if($token->expired_at < $now) {
                return response(['error' => 'Token expirado! Validade do token é de 1 hora.'],401);
            }

            $user = $token->user;

            return response($user, 200);

        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {

            $user = User::find($request->input('id'));
            if(!$user) {
                return response(['error' => 'Usuário não encontrado'],404);
            }

            $user->password = bcrypt($request->input('pass1'));
            $user->save();
            return response(['message' => 'success']);


        } catch (\Exception $ex) {
            return response($ex->getMessage(),500);
        }
    }


}