<?php

namespace App\Http\Controllers\Frontend\Auth;

use Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function adminLogin()
    {
        $users=[];
        try {
            if (Auth::check()) {
                return redirect('dashboard');
            }

            $branch=Config::get('app.APP_BRANCH');
            $APP_STYLE=Config::get('app.APP_STYLE');
            if($branch=='nonsaas' && $APP_STYLE=='demo' && env('APP_SYNC') == 'true'){
                $users= User::with('role')->whereIn('id', [2,3,4])->select('id','name', 'email','role_id')->get();
            }elseif( $branch=='saas' && $APP_STYLE=='demo' && env('APP_SYNC') == 'true'){
                $users= User::with('role')->whereIn('id', [1,2,3,4])->select('id','name', 'email','role_id')->get();
            }else{
                $users=[];
            }
            // return $user;
            return view('backend.auth.admin_login', compact('users'));
        } catch (\Throwable $th) {
        }
    }

    public function LoginForm()
    {
        return view('backend.auth.admin_login');
        return view('auth.login');
    }
}
