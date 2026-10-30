<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('extraction_jobs', function (Blueprint $table) {
            $table->boolean('collect_full_reviews')
                ->default(false)
                ->after('collect_reviews');
        });
    }

    public function down(): void
    {
        Schema::table('extraction_jobs', function (Blueprint $table) {
            $table->dropColumn('collect_full_reviews');
        });
    }
};