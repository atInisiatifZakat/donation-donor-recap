<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use FromHome\Kutt\KuttClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use FromHome\Kutt\Input\CreateShortLinkInput;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DonationRecapDonor extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $appends = [
        'file_url',
        'result_file_url',
    ];

    public function recap(): BelongsTo
    {
        return $this->belongsTo(DonationRecap::class, 'donation_recap_id');
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Recap::getDonorClassModel());
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

    public function getFileUrlAttribute(): ?string
    {
        return $this->getFileUrl();
    }

    public function getResultFileUrlAttribute(): ?string
    {
        return $this->getResultFileUrl();
    }

    public function getFileUrl(): ?string
    {
        /** @var string|null $path */
        $path = $this->getAttribute('file_path');

        return \is_null($path) ? null : $this->generateFileUrl($path);
    }

    public function getResultFileUrl(): ?string
    {
        /** @var string|null $path */
        $path = $this->getAttribute('result_file_path');

        return \is_null($path) ? null : $this->generateFileUrl($path);
    }

    public function getShortUrlResultFile(): ?string
    {
        /** @var string|null $longUrl */
        $longUrl = $this->getResultFileUrl();

        return \is_null($longUrl) ? null : $this->generateShortFileUrl($longUrl);
    }

    protected function generateShortFileUrl(string $longUrl): string
    {
        /** @var KuttClient $client */
        $client = app(KuttClient::class);

        return $client->createShortLink(new CreateShortLinkInput($longUrl))->link;
    }

    protected function generateFileUrl(string $path): string
    {
        $baseUrl = Recap::getDefaultFileUrl();

        if ($baseUrl) {
            return $baseUrl.'/'.$path;
        }

        $disk = Storage::disk($this->getAttribute('disk'));

        if ($disk->providesTemporaryUrls()) {
            return $disk->temporaryUrl($path, now()->addMinutes(30));
        }

        return $disk->url($path);
    }
}
