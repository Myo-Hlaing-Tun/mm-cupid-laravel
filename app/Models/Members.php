<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Members extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "members";
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'phone',
        'email_confirm_code',
        'forget_password_token',
        'gender',
        'date_of_birth',
        'education',
        'city_id',
        'height_feet',
        'height_inches',
        'status',
        'about',
        'work',
        'religion',
        'thumb',
        'verify_photo',
        'partner_gender',
        'partner_min_age',
        'partner_max_age',
        'last_login',
        'point',
        'view_count',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'forget_password_token_created_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    public function getCitiesByMember(): BelongsTo
    {
        return $this->belongsTo(Cities::class,"city_id","id");
    }

    public function getMemberGalleryByMember(): HasMany
    {
        return $this->hasMany(Member_gallery::class,"member_id","id")->whereNull('deleted_at');
    }

    public function getMemberHobbiesByMember(): HasMany
    {
        return $this->hasMany(Member_hobbies::class,"member_id","id")->whereNull('deleted_at');
    }

    public function getDateRequestMember(): HasMany
    {
        return $this->hasMany(Date_request::class,"invite_id","id")->where('status','=',Constants::DATE_REQUEST_SENT);
    }
    public function getDateReceivedMember(): HasMany
    {
        return $this->hasMany(Date_request::class,"accept_id","id")->where('status','=',Constants::DATE_REQUEST_SENT);
    }
    public function getPointPurchases(): HasMany
    {
        return $this->hasMany(Point_Purchase::class,"member_id","id")->where('status','=',Constants::PURCHASE_SENT_STATUS);
    }
}
