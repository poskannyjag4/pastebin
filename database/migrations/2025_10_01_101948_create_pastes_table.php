<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pastes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('text');
            $table->dateTime('expires_at')->nullable();
            $table->string('visibility');
            $table->string('programming_language');
            $table->uuid('token')->unique()->nullable();
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pastes');
    }
};
