<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Date_request extends Model
{
    use HasFactory;
    protected $table = "date_requests";
    protected $fillable = [
        'id',
        'invite_id',
        'accept_id',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];
    public function getMemberByAcceptId(): BelongsTo
    {
        return $this->belongsTo(Members::class,"accept_id","id");
    }
    public function getMemberByInviteId(): BelongsTo
    {
        return $this->belongsTo(Members::class,"invite_id","id");
    }
}
