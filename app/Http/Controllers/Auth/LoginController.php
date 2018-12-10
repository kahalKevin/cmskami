<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return '_email';
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('_email', 'password');
        $user = User::where('_email', '=', $credentials['_email'])->first();

        if (Auth::attempt(['_email' => $credentials['_email'], 'password' => $credentials['password'], '_active' => '1'])) {
            return redirect('/');
        } 

        $message = $user['_active'] == '1' ? 'Wrong email or password !' : 'Your user inactive. please contact administrator';
        
        $errors = [
            'failed' => $message
        ];
        
        return redirect()->back()->withErrors($errors);
    }
 
    public function authenticated(Request $request, $user)
    {
        $user->update([
            '_last_login_at' => Carbon::now()->toDateTimeString(),
            '_last_login_ip' => $request->getClientIp()
        ]);
    }
}
