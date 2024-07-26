<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cron_job extends Model
{
    use HasFactory;
    protected $table = "cron_job";
    protected $fillable = [
        'id',
        'cron_job_number',
        'sender_member_id',
        'suggest_member_id',
        'created_at',
        'updated_at',
    ];
}
