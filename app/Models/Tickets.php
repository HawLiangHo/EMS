<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $table = "tickets";
    protected $primarykey = "id";

    protected $fillable = [
        'event_id',
        'name',
        'type',
        'quantity',
        'quantity_left',
        'price',
        'ticket_qr'

    ];

    public function ticket(){
        return $this->belongsTo(Events::class, "event_id");
    }
}