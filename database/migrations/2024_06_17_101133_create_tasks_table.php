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
            $table->string('subject'); // Тема письма
            $table->string('sender'); // Отправитель
            $table->json('recipients')->nullable(); // Адресаты в копии
            $table->text('body'); // Тело письма
            $table->json('attachments')->nullable(); // Вложения
            $table->enum('status', ['Новая', 'В процессе', 'В ожидании', 'Закрыто'])->default('Новая'); // Статус заявки
            $table->unsignedBigInteger('assigned_to')->nullable(); // Ответственный
            $table->integer('priority')->default(1); // Приоритет
            $table->timestamps();
            // Добавление внешнего ключа
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });

        // Добавление проверки для поля priority
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
