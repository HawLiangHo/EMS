<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = "events";
    protected $primarykey = "id";

    protected $fillable = [
        'created_by',
        'username',
        'title',
        'description',
        'category',
        'tags',
        'type',
        'venue_name',
        'venue_address',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'registration_start_date',
        'registration_end_date',
        'num_of_participant',
        'publish_status',
        'event_status',
        'cover_image'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, "created_by");
    }

    public function users() {
        return $this->belongsToMany(User::class, "user_event", "event_id", "user_id");
    }
    
    public function assistants() {
        return $this->belongsToMany(User::class, "assistant_event", "event_id", "assistant_id");
    }

    public function tickets() {
        return $this->hasMany(Tickets::class, "event_id");
    }

    public function pageVisits() {
        return $this->hasMany(PageVisit::class, "event_id");
    }

    public function checkouts() {
        return $this->hasManyThrough(Checkout::class, Tickets::class, "event_id", "ticket_id");
    }
}