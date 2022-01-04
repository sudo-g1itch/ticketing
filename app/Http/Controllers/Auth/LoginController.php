<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Client;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        if( $request->get('key') == 'thekey'){
            $user = Client::where('name',$request->get('name'))->where('uuid', $request->get('uuid'))->first();
            if($user){
                \Auth::guard('client_guard')->loginUsingId($user->id);
                $request->session()->regenerate();
                return redirect()->intended('client');
            }else{
                $client = new Client;
                $client->name = $request->get('name');
                $client->company = $request->get('company');
                $client->ownership_id = 1;
                $client->uuid = \Str::random(128);
                $client->save();
                \Auth::guard('client_guard')->loginUsingId($client->id);
                $request->session()->regenerate();
                return redirect()->intended('client');
            }
        }

    }


    public function logout(){
        \Auth::logout();
        return redirect('/');
    }
}
