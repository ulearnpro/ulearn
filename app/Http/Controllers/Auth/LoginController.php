<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->is_active && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // login form with an error message.
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'You must be active to login.']);
            }
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function authenticated($request , $user){

        if($user->hasRole('instructor')){
            return redirect()->route('instructor.dashboard') ;
        }
        elseif($user->hasRole('admin')){
            return redirect()->route('admin.dashboard') ;
        }else{
            return redirect()->route('home') ;
        }
    }

    /**
    * Handle Social login request
    *
    * @return response
    */
 
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
 
   /**
    * Obtain the user information from Social Logged in.
    * @param $social
    * @return Response
    */
 
    public function handleProviderCallback($social)
    {
 
        $userSocial = Socialite::driver($social)->user();
        // echo '<pre>';print_r($userSocial);exit;
        $user = User::where(['email' => $userSocial->getEmail()])->first();
 
       if($user){
 
            Auth::login($user);
            return redirect()->action('HomeController@index');
 
       }else{
 
            return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);
        }
 
   }
}
