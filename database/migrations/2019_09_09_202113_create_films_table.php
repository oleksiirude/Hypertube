<?php
    
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
    class CreateFilmsTable extends Migration
    {
        public $timestamps = false;
        
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('films', function (Blueprint $table) {
                $table->string('imdb_id', 20)->unique();
                $table->string('prod_year', 4);
                $table->string('rating', 20);
            });
        }
        
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('films');
        }
    }
