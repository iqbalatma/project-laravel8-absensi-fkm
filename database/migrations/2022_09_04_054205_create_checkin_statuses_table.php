<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCheckinStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_statuses', function (Blueprint $table) {
            $table->id();
            $table->boolean('checkin_status')->default(1);
            $table->bigInteger('user_id');
            $table->bigInteger('congress_day_id');
            $table->timestamp('last_checkin_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('last_checkout_time')->nullable(true);
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
        Schema::dropIfExists('checkin_statuses');
    }
}
