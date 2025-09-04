<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Model;
use Inisiatif\DonationRecap\DonationRecap as Recap;

final class DonorTaxNumber extends Model
{
    public function getTable(): string
    {
        return Recap::getDonorTaxNumberTable() ?? parent::getTable();
    }
}
