<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_days', function (Blueprint $table) {
            $table->id();
            $table->string('tab_label');
            $table->date('date');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('agenda_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_day_id')->constrained()->cascadeOnDelete();
            $table->string('overline')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_items');
        Schema::dropIfExists('agenda_days');
    }
};
