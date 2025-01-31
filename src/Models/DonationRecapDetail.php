<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class DonationRecapDetail extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'donation_transaction_date' => 'datetime',
    ];

    public function getTransactionDate(): Carbon
    {
        return $this->getAttribute('donation_transaction_date');
    }

    public function getTotalAmount(): float
    {
        return $this->getAttribute('donation_amount') * $this->getAttribute('currency_rate');
    }
}
