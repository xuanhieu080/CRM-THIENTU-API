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
        Schema::table('deals', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->unsignedBigInteger('contact_id')->nullable()->change();
            $table->string('contact_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->unsignedBigInteger('contact_id')->nullable()->change();
            $table->string('contact_name')->nullable()->change();
        });
    }
};
