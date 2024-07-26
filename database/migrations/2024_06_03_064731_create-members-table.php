<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('username',200)->nullable();
            $table->string('email',100)->nullable();
            $table->string('password',100)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('email_confirm_code',32)->nullable();
            $table->string('forget_password_token',32)->nullable();
            $table->unsignedTinyInteger('gender')->nullable()->comment("1=male, 2=female");
            $table->date('date_of_birth');
            $table->mediumText('education')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('height_feet')->nullable();
            $table->unsignedInteger('height_inches')->nullable();
            $table->unsignedTinyInteger('status')->nullable()
            ->comment("0=registered, 1=email-confirmed, 2=photo-verification-pending, 3= photo-verification-failed, 4= photo-verified, 5=ban, 6=dating");
            $table->text('about')->nullable();
            $table->string('work',200)->nullable();
            $table->unsignedInteger('religion')->nullable();
            $table->string('thumb',100)->nullable();
            $table->longText('verify_photo')->nullable();
            $table->unsignedTinyInteger('partner_gender')->nullable()->comment("1=male, 2=female, 3=both");
            $table->unsignedInteger('partner_min_age')->nullable();
            $table->unsignedInteger('partner_max_age')->nullable();
            $table->dateTime('last_login', $precision = 0)->nullable();
            $table->unsignedInteger('point')->nullable();
            $table->unsignedInteger('view_count')->nullable();
            $table->unsignedTinyInteger('deleted_by')->nullable();
            $table->dateTime('forget_password_token_created_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
