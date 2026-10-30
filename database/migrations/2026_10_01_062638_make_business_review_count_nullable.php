<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->unsignedInteger('review_count')
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->unsignedInteger('review_count')
                ->default(0)
                ->nullable(false)
                ->change();
        });
    }
};