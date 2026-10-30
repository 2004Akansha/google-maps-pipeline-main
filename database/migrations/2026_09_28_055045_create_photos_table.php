<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_id')
                  ->constrained('businesses')
                  ->cascadeOnDelete();

            $table->text('photo_url');

            $table->string('photo_key');

            $table->string('photo_type')->nullable();

            $table->text('source_url')->nullable();

            $table->timestamps();

            $table->unique(['business_id', 'photo_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};