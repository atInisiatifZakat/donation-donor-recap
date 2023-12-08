<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DonationRecapDonor extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function recap(): BelongsTo
    {
        return $this->belongsTo(DonationRecap::class, 'donation_recap_id');
    }

    /**
     * @return resource|null
     */
    public function getRecapStreamFile()
    {
        $disk = Storage::disk($this->getAttribute('disk'));

        $path = $this->getAttribute('file_path');

        return $disk->readStream($path);
    }
}
