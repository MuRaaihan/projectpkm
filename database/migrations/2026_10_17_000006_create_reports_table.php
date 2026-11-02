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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_hidden_identity')->default(false);
            $table->string('reporter_class_name', 30)->nullable();
            $table->unsignedTinyInteger('reporter_grade_level')->nullable();
            $table->enum('reporter_role', ['korban', 'saksi']);
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->date('incident_date');
            $table->string('location', 150);
            $table->text('description'); // encrypted at application level
            $table->text('accused_name')->nullable(); // encrypted at application level
            $table->enum('urgency', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('status', ['baru', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->default('baru');
            $table->text('reject_reason')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('category_id');
            $table->index('reporter_id');
            $table->index('created_at');
            $table->index('reporter_class_name');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
