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

    public function statuses()
    {
        return $this->hasMany(Status::class);
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
                    ->orderBy('created_at','desc');
    }
}
