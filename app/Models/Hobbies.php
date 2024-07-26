<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hobbies extends Model
{
    use HasFactory;

    protected $table = "hobbies";
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function getMemberHobbiesByHobbies(): HasMany
    {
        return $this->hasMany(Member_hobbies::class,"hobby_id","id");
    }
}
