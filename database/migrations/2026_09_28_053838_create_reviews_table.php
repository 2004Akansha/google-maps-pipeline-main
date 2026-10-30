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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('external_review_id')->nullable();

            $table->string('author')->nullable();

            $table->decimal('rating', 2, 1)->nullable();

            $table->date('review_date')->nullable();

            $table->text('review_text')->nullable();

            $table->text('owner_response')->nullable();

            $table->text('source_url')->nullable();

            $table->timestamps();

            $table->unique([
                'business_id',
                'external_review_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
