<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Passport config
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->config = config('passport');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = $this->getToken($request);
        if (isset($token['access_token'])){
            return $this->successResponse($token);
        }

        return $this->errorResponse($token);
    }

    /**
     * Generate new auth token for the user
     *
     * @param Request $request
     * @return mixed
     */
    public function getToken(Request $request)
    {
        $credentials = $this->credentials($request);
        $url = config('app.url') . '/oauth/token';

        $response = Http::post($url, [
            'grant_type' => 'password',
            'client_id' => $this->config['password_client_id'],
            'client_secret' => $this->config['password_client_secret'],
            'username' => $credentials[$this->username()],
            'password' => $credentials['password'],
            'scope' => '',
        ]);

        return $response->json();
    }
}
