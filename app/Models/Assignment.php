<?php

namespace App\Models;

use Database\Factories\AssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    /** @use HasFactory<AssignmentFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'license_id',
        'employee_id',
        'assigned_date',
        'revoked_date',
        'status',
        'device_info',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'assigned_date' => 'date',
            'revoked_date' => 'date',
        ];
    }

    /**
     * Get the license associated with this assignment.
     *
     * @return BelongsTo<License, Assignment>
     */
    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    /**
     * Get the employee to whom the license is assigned.
     *
     * @return BelongsTo<Employee, Assignment>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Check if assignment is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
