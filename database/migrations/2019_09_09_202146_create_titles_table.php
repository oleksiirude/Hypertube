<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
    class CreateTitlesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('titles', function (Blueprint $table) {
                $table->string('imdb_id', 20)->unique();
                $table->string('en_title', 255);
                $table->string('uk_title', 255);
                $table->string('ru_title', 255);
            });
        }
    
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('titles');
        }
    }
