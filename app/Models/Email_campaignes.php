<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email_campaignes extends Model
{
    use HasFactory;
    protected $table = "email_campaignes";
    protected $fillable = [
        'id',
        'member_id',
        'campaigne_type',
        'created_at',
        'created_by',
        'updated_at',
    ];
}
