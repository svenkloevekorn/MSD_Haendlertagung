<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('form_slug');
            $table->json('data');
            $table->timestamps();

            $table->index('form_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
