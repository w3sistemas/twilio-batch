<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->string('raw_number');
            $table->string('e164')->nullable();
            $table->string('country_code')->nullable();
            $table->string('carrier')->nullable();
            $table->string('type')->nullable();
            $table->boolean('valid')->nullable();
            $table->text('lookup_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_items');
    }
};
