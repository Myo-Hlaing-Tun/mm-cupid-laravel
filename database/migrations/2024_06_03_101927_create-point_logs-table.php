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
        Schema::create('point_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id')->nullable();
            $table->unsignedInteger('search_id')->nullable();
            $table->unsignedInteger('date_request_id')->nullable();
            $table->unsignedBigInteger('point')->nullable();
            $table->unsignedInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('added_point')->nullable();
            $table->unsignedBigInteger('subtracted_point')->nullable();
            $table->unsignedTinyInteger('created_by')->nullable();
            $table->timestamps();
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
