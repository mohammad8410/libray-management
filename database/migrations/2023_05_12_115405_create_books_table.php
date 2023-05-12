<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('name');
            $table->json('authors');
            $table->json('translators')->nullable();
            $table->integer('year');
            $table->integer('volume');
            $table->integer('pages');
            $table->integer('price');
            $table->integer('number');
            $table->timestamp('maximumTime');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
