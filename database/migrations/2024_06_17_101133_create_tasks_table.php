<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority')->default(1);
            $table->timestamps();
        });

        // Добавление проверки
        DB::statement('ALTER TABLE tasks ADD CONSTRAINT check_priority CHECK (priority BETWEEN 1 AND 5)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Удаление проверки
        DB::statement('ALTER TABLE tasks DROP CONSTRAINT check_priority');

        Schema::dropIfExists('tasks');
    }
}
