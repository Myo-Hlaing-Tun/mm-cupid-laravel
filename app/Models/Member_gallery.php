<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member_gallery extends Model
{
    use HasFactory;
    protected $table = "member_gallery";
    protected $fillable = [
        'id',
        'member_id',
        'name',
        'sort',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function getMembersByMemberGallery(): BelongsTo
    {
        return $this->belongsTo(Members::class,"member_id","id");
    }
}
