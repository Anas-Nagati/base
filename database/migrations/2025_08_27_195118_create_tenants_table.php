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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // Website name
            $table->string('domain')->unique();           // WordPress site URL
            $table->string('api_token', 80)->unique();    // Token used for authentication
            $table->string('owner_email')->nullable();    // Admin email
            $table->enum('plan', ['free', 'paid'])->default('free');
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
