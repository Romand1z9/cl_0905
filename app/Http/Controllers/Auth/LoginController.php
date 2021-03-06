<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/admin';

    protected $loginView;

    protected $username = 'login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->loginView = config('settings.theme').'.login';
    }

    public function username()
    {
        return $this->username;
    }

    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView') ? $this->loginView : '';

        if (view()->exists($view))
        {
            return view($view)->with(['title' => 'Вход на сайт', 'sidebar' => 'no']);
        }

        abort(404);
    }

}
