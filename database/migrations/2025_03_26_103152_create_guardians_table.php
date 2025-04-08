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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->nullable();
            $table->foreignId('parent_id')
                  ->constrained('parent_users')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->text('address')->nullable();
            $table->enum('relationship', ['maid', 'grandparent', 'relative', 'other']);
            $table->enum('id_type', ['passport', 'driver_license', 'national_id', 'other']);
            $table->string('id_number')->unique();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
