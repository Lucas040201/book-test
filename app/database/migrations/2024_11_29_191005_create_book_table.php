<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_book', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title');
            $table->string('description');
            $table->integer('price')->default(0);
            $table->integer('quantity')->default(0);
            $table->unsignedInteger('author_id')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('tb_author');
            $table->index(['title', 'description', 'price', 'quantity', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_book');
    }
};
