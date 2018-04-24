<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user)
        {
            $user->activation_token = str_random(30);
        });
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::Class,'followers','user_id','follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::Class,'followers','follower_id','user_id');
    }

    public function follow($user_ids)
    {
        if (! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids,false);
    }

    public function unfollow($user_ids)
    {
        if (! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function is_follow($user_id)
    {
        return $this->followings->contains($user_id);
    }

    public function getavatar($size = '100')
    {
        if ($this->attributes['avatar']) {
            return $this->attributes['avatar'];
        } else {
            $hash = md5(strtolower(trim($this->attributes['email'])));
            return "http://s.gravatar.com/avatar/$hash?s=$size";
        }
    }

    public function statuses_order_desc()
    {
        return $this->statuses()
                    ->with('user')
                    ->orderBy('created_at','desc');
    }

    public function followers_statuses_order_desc()
    {
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)
                    ->with('user')
                    ->orderBy('created_at','desc');
    }
}
