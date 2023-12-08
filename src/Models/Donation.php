<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Inisiatif\DonationRecap\DonationRecap as Recap;

final class Donation extends Model
{
    use HasUuids;

    public function getTable(): string
    {
        return Recap::getDonationTable() ?? parent::getTable();
    }
}
