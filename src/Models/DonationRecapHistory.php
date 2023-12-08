<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class DonationRecapHistory extends Model
{
    use HasUuids;

    protected $guarded = [];
}
