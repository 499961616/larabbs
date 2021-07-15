<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory,Notifiable,MustVerifyEmailTrait;

    //消息通知判断
    public function topicNotify($instance)
    {

        //自己发自己的话题就不需要提醒
        if ($this->id ==Auth::id()){
            return false;
        }
            $this->increment('notification_count');

        $this->notify($instance);
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);

    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
