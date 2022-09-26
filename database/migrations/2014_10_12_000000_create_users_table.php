<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',128);
            $table->string('personal_token')->nullable();
            $table->string('email')->unique();
            $table->string('password',512);
            $table->string('student_id',8)->nullable(true);
            $table->string('generation')->nullable(true);
            $table->string('phone_number')->nullable(true);
            $table->bigInteger('organization_id')->nullable(true);
            $table->bigInteger('role_id')->nullable(true);
            $table->timestamp('email_verified_at')->nullable(true);
            $table->boolean('is_active')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
