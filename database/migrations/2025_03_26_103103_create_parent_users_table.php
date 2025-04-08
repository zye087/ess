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
        Schema::create('parent_users', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->unique();
            $table->text('address')->nullable();
            $table->enum('parent_type', ['father', 'mother']);
            $table->enum('id_type', ['passport', 'driver_license', 'national_id', 'sss_id', 'other_id']);
            $table->string('id_photo')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->string('verification_token')->nullable();
            $table->longText('face_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_users');
    }
};
