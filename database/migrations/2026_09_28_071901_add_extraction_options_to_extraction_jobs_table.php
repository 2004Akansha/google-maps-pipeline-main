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
    Schema::table('extraction_jobs', function (Blueprint $table) {
        $table->string('search_query')->after('source_id');

        $table->boolean('collect_business_details')
            ->default(true)
            ->after('search_query');

        $table->boolean('collect_reviews')
            ->default(true)
            ->after('collect_business_details');

        $table->boolean('collect_photos')
            ->default(true)
            ->after('collect_reviews');
    });
}

public function down(): void
{
    Schema::table('extraction_jobs', function (Blueprint $table) {
        $table->dropColumn([
            'search_query',
            'collect_business_details',
            'collect_reviews',
            'collect_photos',
        ]);
    });
}
};
