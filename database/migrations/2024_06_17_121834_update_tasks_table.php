<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('subject');
            $table->string('sender');
            $table->text('body');
            $table->json('recipients')->nullable();
            $table->json('attachments')->nullable();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->enum('status', ['new', 'in_progress', 'on_hold', 'closed'])->default('new');
    
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['subject', 'sender', 'body', 'recipients', 'attachments', 'assigned_user_id', 'status']);
        });
    }
    
}
