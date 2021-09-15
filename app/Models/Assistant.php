<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class Assistant extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;

    protected $guard = 'assistant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'role',
        'address',
        'credit_balance',
        'event_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function event(){
        return $this->belongsTo(Events::class, "event_id");
    }

    public function users(){
        return $this->belongsTo(User::class, "id");
    }

    //new lines
    public function isAssistant()
    {
        if ($this->role == 2) {
            return true;
        }
        return false;
    }

}
