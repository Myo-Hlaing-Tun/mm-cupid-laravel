<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point_Purchase extends Model
{
    use HasFactory;
    protected $table = "point_purchase";
    protected $fillable = [
        'id',
        'member_id',
        'screenshot',
        'status',
        'point',
        'created_at',
        'created_by',
        'updated_at',
    ];
    public function getMemberByMemberId(): BelongsTo
    {
        return $this->belongsTo(Members::class,"member_id","id");
    }
}
