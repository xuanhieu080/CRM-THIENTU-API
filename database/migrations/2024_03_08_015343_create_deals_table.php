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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('contact_name');
            $table->unsignedBigInteger('service_id');
            $table->string('service_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('PENDING')->nullable();
            $table->string('priority')->default('NONE')->nullable();
            $table->string('type')->default('NONE')->nullable();
            $table->double('total')->default(0)->nullable();
            $table->integer('headcounts')->default(0)->nullable();
            $table->integer('probability')->default(0)->nullable();
            $table->double('price')->default(0)->nullable();
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
