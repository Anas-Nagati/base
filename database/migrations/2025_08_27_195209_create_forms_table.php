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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('wp_form_id');    // The form ID from WordPress (CF7, Gravity, etc.)
            $table->string('name');                      // Form name (from WP)
            $table->json('fields');                      // Field definitions
            $table->string('sheet_id')->nullable();      // Google Sheet ID if mapped
            $table->timestamps();

            $table->unique(['tenant_id', 'wp_form_id']); // Prevent duplicate form sync
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
