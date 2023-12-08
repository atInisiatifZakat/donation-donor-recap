<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Inisiatif\DonationRecap\Enums\DonationRecapState;

final class DonationRecap extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'state' => DonationRecapState::class,
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(DonationRecapTemplate::class);
    }

    public function donors(): HasMany
    {
        return $this->hasMany(DonationRecapDonor::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(DonationRecapHistory::class);
    }

    public function state(DonationRecapState $state): self
    {
        $this->update(['state' => $state]);

        return $this;
    }

    public function recordHistory(string $description, ?string $donorId = null): void
    {
        $this->histories()->create([
            'description' => $description,
            'donor_id' => $donorId,
        ]);
    }

    public function getPeriodStartDate(): Carbon
    {
        return $this->getAttribute('start_at');
    }

    public function getPeriodEndDate(): Carbon
    {
        return $this->getAttribute('end_at');
    }

    public function inState(DonationRecapState $new): bool
    {
        $state = $this->getAttribute('state');

        return $state->value === $new->value;
    }
}
