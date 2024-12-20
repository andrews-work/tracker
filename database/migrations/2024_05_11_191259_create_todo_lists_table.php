<!-- database/migrations/TodoList.php -->

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Run the migrations.
    public function up() {
        Schema::create('todoList', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('category');
            $table->string('importance');
            $table->date('date');
            $table->string('color');
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    // Reverse the migrations.
    public function down(): void {

        dd('down method called');
        Schema::table('todoList', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    
        Schema::dropIfExists('todoList');
    }
};