<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('photos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con users
    $table->string('file_path');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->unsignedInteger('likes_count')->default(0);
    $table->unsignedInteger('comments_count')->default(0);
    $table->boolean('reward_claimed')->default(false);
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
        Schema::dropIfExists('photos');
    }
}
