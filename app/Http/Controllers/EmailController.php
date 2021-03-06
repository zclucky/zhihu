<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    //
    public function verify($token){
        $user = User::where('confirmation_token',$token)->first();

        if(is_null($user)){
            flash('邮箱验证失败')->error();
            return redirect('/');
        }

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();

        if(!Auth::check()){
            Auth::login($user); //登录
            flash('邮箱验证成功')->success();
            return redirect('/home');
        }
        return redirect('/');
    }
}
