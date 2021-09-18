<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = "checkouts";
    protected $primarykey = "id";

    protected $fillable = [
        'user_id',
        'ticket_id',
        'quantity',
        'total_price'

    ];
}
