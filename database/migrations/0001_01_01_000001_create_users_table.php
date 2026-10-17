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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['master', 'bk', 'siswa'])->index();
            $table->string('login_id', 50)->unique(); // NIS (siswa), NIP/username (bk), username (master)
            $table->string('name', 100);
            $table->string('password', 255);
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('must_change_password')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('locked_until')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
