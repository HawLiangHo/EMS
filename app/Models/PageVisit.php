<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;

    protected $table = "page_visit";
    protected $primarykey = "id";

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    protected $fillable = [
        'event_id',
        'visit_count'
    ];
}