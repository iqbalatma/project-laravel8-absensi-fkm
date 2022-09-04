<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->boolean('is_active');
            $table->bigInteger('role_id');
            $table->bigInteger('organization_id')->nullable();
            $table->bigInteger('limit')->default(1);
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
        Schema::dropIfExists('registration_credentials');
    }
}
