<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member_hobbies extends Model
{
    use HasFactory;
    protected $table = "member_hobbies";
    protected $fillable = [
        'id',
        'member_id',
        'hobby_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function getMembersByMemberHobbies(): BelongsTo
    {
        return $this->belongsTo(Members::class,"member_id","id");
    }

    public function getHobbyByMemberHobbies(): BelongsTo
    {
        return $this->belongsTo(Hobbies::class,"hobby_id","id");
    }
}
