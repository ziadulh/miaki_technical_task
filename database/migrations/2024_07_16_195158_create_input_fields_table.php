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
        Schema::create('input_fields', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['text', 'email', 'password', 'select', 'checkbox', 'radio', 'textarea'])->default('text');
            $table->string('name', 50);
            $table->string('label', 50);
            $table->string('placeholder', 50)->nullable();
            $table->boolean('required')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_fields');
    }
};
