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
        Schema::table('services', function (Blueprint $table) {
            $table->string('description', 300)->nullable();
            $table->boolean('is_default')->default(0);
        });
        Schema::table('contact_sources', function (Blueprint $table) {
            $table->string('description', 300)->nullable();
            $table->boolean('is_default')->default(0);
        });
        Schema::table('contact_funnels', function (Blueprint $table) {
            $table->string('description', 300)->nullable();
            $table->boolean('is_default')->default(0);
        });
        Schema::table('lead_statuses', function (Blueprint $table) {
            $table->string('description', 300)->nullable();
            $table->boolean('is_default')->default(0);
        });
        Schema::table('deal_stages', function (Blueprint $table) {
            $table->string('description', 300)->nullable();
            $table->boolean('is_default')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deal_stages', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_default']);
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_default']);
        });
        Schema::table('contact_funnels', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_default']);
        });
        Schema::table('contact_sources', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_default']);
        });
        Schema::table('lead_statuses', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_default']);
        });
    }
};
