<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Inisiatif\DonationRecap\DonationRecap as Recap;

final class DonorPhone extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_primary' => 'bool',
        'is_valid_format' => 'bool',
        'is_support_whatsapp' => 'bool',
    ];

    public function getTable(): string
    {
        return Recap::getDonorPhoneTable() ?? parent::getTable();
    }

    public function isSupportWhatsApp(): bool
    {
        return (bool) $this->getAttribute('is_support_whatsapp');
    }

    public function getNumberAttribute(string $value): string
    {
        return trim($value);
    }
}
