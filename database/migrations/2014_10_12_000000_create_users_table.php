<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
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
                $table->uuid('uuid');
                $table->string('login');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('avatar')->default(DEFAULT_AVATAR);
                $table->string('info', 500)->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('auth_provider')->nullable();;
                $table->string('auth_provider_id')->nullable();;
                $table->rememberToken();
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
            Schema::dropIfExists('users');
        }
    }
