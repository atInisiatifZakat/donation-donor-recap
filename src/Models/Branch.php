<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Inisiatif\DonationRecap\DonationRecap as Recap;

final class Branch extends Model
{
    use SoftDeletes;
    use HasUuids;

    public function getTable(): string
    {
        return Recap::getBranchTable() ?? parent::getTable();
    }

    protected $casts = [
        'deleted_at' => 'datetime',
        'is_head_office' => 'bool',
    ];
}
