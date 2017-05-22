<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirmation_token','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

  /*  //发送邮件
    public function sendPasswordResetNotification($token){
        $data = [
            'url' =>  url(config('app.url').route('password.reset', $token, false)),
        ];
        $template = new SendCloudTemplate('zhihu_app_reset_password', $data);

        Mail::raw($template, function ($message){
            $message->from('409542824@qq.com', 'zhihu-app');
            $message->to($this->email);
        });
    }*/
}
