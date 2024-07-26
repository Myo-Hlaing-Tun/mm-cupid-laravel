<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search_logs extends Model
{
    use HasFactory;
    protected $table = "search_logs";
    protected $fillable = [
        'id',
        'min_age',
        'max_age',
        'city_id',
        'partner_gender',
        'created_at',
        'created_by',
        'updated_at',
    ];
}
