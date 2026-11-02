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
        Schema::create('periodic_report_summaries', function (Blueprint $table) {
            $table->id();
            $table->enum('period_type', ['monthly', 'semester'])->index();
            $table->string('period_label', 100)->index();
            $table->date('start_date')->index();
            $table->date('end_date')->index();
            $table->unsignedInteger('total_reports')->default(0);
            $table->unsignedInteger('new_reports')->default(0);
            $table->unsignedInteger('in_process_reports')->default(0);
            $table->unsignedInteger('resolved_reports')->default(0);
            $table->unsignedInteger('rejected_reports')->default(0);
            $table->unsignedInteger('urgent_high_reports')->default(0);
            $table->unsignedInteger('urgent_medium_reports')->default(0);
            $table->unsignedInteger('urgent_low_reports')->default(0);
            $table->json('categories_breakdown')->nullable();
            $table->json('classes_breakdown')->nullable();
            $table->decimal('avg_resolution_days', 5, 2)->nullable();
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->unique(['period_type', 'period_label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodic_report_summaries');
    }
};
