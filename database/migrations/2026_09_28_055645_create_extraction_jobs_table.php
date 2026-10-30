<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extraction_jobs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('source_id')
                ->constrained('sources')
                ->cascadeOnDelete();

            $table->enum('status', [
                'pending',
                'running',
                'completed',
                'failed',
                'cancelled'
            ])->default('pending');

            $table->timestamp('started_at')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->unsignedInteger('total_businesses')
                ->default(0);

            $table->unsignedInteger('processed_businesses')
                ->default(0);

            $table->unsignedInteger('successful_businesses')
                ->default(0);

            $table->unsignedInteger('failed_businesses')
                ->default(0);

            $table->text('error_message')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extraction_jobs');
    }
};