<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();

            // Relationship with sources table
            $table->foreignId('source_id')
                ->constrained('sources')
                ->cascadeOnDelete();

            // Business information
            $table->string('name');
            $table->string('category')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Google Maps information
            $table->decimal('rating', 2, 1)->nullable();
            $table->unsignedInteger('review_count')->default(0);
            $table->text('maps_url')->nullable();
            $table->string('external_id')->nullable();

            // Pipeline status
            $table->string('status')->default('active');

            // When the business was collected
            $table->timestamp('collected_at')->nullable();

            $table->timestamps();

            // Prevent duplicate businesses for the same source
            $table->unique(
                ['source_id', 'external_id'],
                'businesses_source_external_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};