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
            $table->string('token',64)->nullable(false);
            $table->boolean('is_active')->default(1);
            $table->bigInteger('role_id')->nullable(true);
            $table->bigInteger('organization_id')->nullable(true);
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
