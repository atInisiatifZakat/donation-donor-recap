<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DonationDetail extends Model
{
    protected $casts = [
        'donation_transaction_date',
    ];

    public function getTable(): string
    {
        return Recap::getDonationDetailTable() ?? parent::getTable();
    }

    public function donation(): BelongsTo
    {
        return $this->belongsTo(
            Recap::getDonationClassModel()
        );
    }

    public function getTransactionDate(): Carbon
    {
        return $this->getAttribute('donation_transaction_date');
    }
}
