<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodicReportSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_type',
        'period_label',
        'start_date',
        'end_date',
        'total_reports',
        'new_reports',
        'in_process_reports',
        'resolved_reports',
        'rejected_reports',
        'urgent_high_reports',
        'urgent_medium_reports',
        'urgent_low_reports',
        'categories_breakdown',
        'classes_breakdown',
        'avg_resolution_days',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'categories_breakdown' => 'array',
            'classes_breakdown' => 'array',
            'avg_resolution_days' => 'float',
            'generated_at' => 'datetime',
        ];
    }
}
