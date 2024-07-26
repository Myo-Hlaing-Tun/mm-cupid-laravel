<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Point_logs extends Model
{
    use HasFactory;
    protected $table = "point_logs";
    protected $fillable = [
        'id',
        'member_id',
        'search_id',
        'date_request_id',
        'point',
        'purchase_id',
        'added_point',
        'subtracted_point',
        'created_at',
        'created_by',
        'updated_at',
    ];
    public function getMembersByPointLog(): BelongsTo
    {
        return $this->belongsTo(Members::class,"member_id","id");
    }

    public function getUserByPointLog(): BelongsTo
    {
        return $this->belongsTo(User::class,"created_by","id");
    }
    public function getPurchaseDetailsByPointLog(): HasOne
    {
        return $this->hasOne(Point_Purchase::class,'id','purchase_id');
    }
}
