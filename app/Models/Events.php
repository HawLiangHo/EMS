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
        'user_id',
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

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
    public function assistants() {
        return $this->hasMany(Assistants::class, "id");
    }
}
