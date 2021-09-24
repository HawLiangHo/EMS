<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;

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
        'event_id',
        'assistant_id'
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

    //new lines
    public function isAdmin() {
        if ($this->role == 0) {
            return true;
        }
        return false;
    }

    public function isParticipant()
    {
        if ($this->role == 1) {
            return true;
        }
        return false;
    }

    public function isAssistant()
    {
        if ($this->role == 2) {
            return true;
        }
        return false;
    }
    
    // return all event that are registered by this user
    public function events() {
        return $this->belongsToMany(Events::class, "user_event", "user_id", "event_id");
    }

    public function tickets() {
        return $this->belongsToMany(Tickets::class, Checkout::class, "user_id", "ticket_id");
    }

    public function checkouts() {
        return $this->hasMany(Checkout::class, "user_id");
    }

    // return all event that assistant by this user
    public function assistantEvents() {
        return $this->belongsToMany(Events::class, "assistant_event", "assistant_id", "event_id");
    }

    // return all event that are created by this user
    public function createdEvents() {
        return $this->hasMany(Events::class, "created_by");
    }
}
