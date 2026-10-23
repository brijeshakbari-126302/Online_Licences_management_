<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\LicenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class License extends Model
{
    /** @use HasFactory<LicenseFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'vendor_id',
        'software_name',
        'license_key',
        'license_type',
        'category',
        'total_seats',
        'cost_per_seat',
        'currency',
        'billing_cycle',
        'purchase_date',
        'expiration_date',
        'status',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'expiration_date' => 'date',
            'cost_per_seat' => 'decimal:2',
            'total_seats' => 'integer',
        ];
    }

    /**
     * Get the vendor that owns this license.
     *
     * @return BelongsTo<Vendor, License>
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get all assignments for this license.
     *
     * @return HasMany<Assignment>
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get active assignments for this license.
     *
     * @return HasMany<Assignment>
     */
    public function activeAssignments(): HasMany
    {
        return $this->hasMany(Assignment::class)->where('status', 'active');
    }

    /**
     * Get employees assigned to this license.
     *
     * @return BelongsToMany<Employee>
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'assignments')
            ->withPivot(['id', 'assigned_date', 'revoked_date', 'status', 'device_info', 'notes'])
            ->withTimestamps();
    }

    /**
     * Count assigned seats currently in use.
     */
    public function getAssignedSeatsCountAttribute(): int
    {
        return $this->activeAssignments()->count();
    }

    /**
     * Count available remaining seats.
     */
    public function getAvailableSeatsCountAttribute(): int
    {
        return max(0, $this->total_seats - $this->assigned_seats_count);
    }

    /**
     * Seat utilization percentage.
     */
    public function getUtilizationPercentageAttribute(): int
    {
        if ($this->total_seats <= 0) {
            return 0;
        }

        return (int) min(100, round(($this->assigned_seats_count / $this->total_seats) * 100));
    }

    /**
     * Total cost for all seats.
     */
    public function getTotalCostAttribute(): float
    {
        return (float) ($this->cost_per_seat * $this->total_seats);
    }

    /**
     * Check if the license is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiration_date !== null && $this->expiration_date->isPast();
    }

    /**
     * Check if the license is expiring in next 30 days.
     */
    public function isExpiringSoon(): bool
    {
        if ($this->expiration_date === null) {
            return false;
        }

        return ! $this->isExpired() && $this->expiration_date->diffInDays(Carbon::now()) <= 30;
    }
}
