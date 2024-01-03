<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Inisiatif\DonationRecap\GeneratePdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\DonationRecap\Models\DonationRecapTemplate;

final class CombineDonorRecapFile implements ShouldBeUnique, ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly DonationRecap $donationRecap,
        public readonly DonationRecapDonor $donor,
    ) {
    }

    public function handle(): void
    {
        if ($this->donationRecap->inState(DonationRecapState::generated)) {
            $this->donationRecap->recordHistory(
                \sprintf('Menggabungkan file rekap dengan template untuk %s', $this->donor->getAttribute('donor_name')),
                $this->donor->getAttribute('donor_id'));

            $this->donationRecap->state(DonationRecapState::combining);

            /** @var DonationRecapTemplate $template */
            $template = $this->donationRecap->template()->first();

            $newContent = GeneratePdf::combine([
                $template->getPrefixStreamFile(),
                $this->donor->getRecapStreamFile(),
                $template->getSuffixStreamFile(),
            ]);

            $path = \sprintf('%s/%s/%s.pdf', Recap::getFileResultBasePath(), now()->year, Str::random(64));

            Storage::disk(Recap::getDefaultFileDisk())->put($path, $newContent);

            $this->donor->update([
                'result_disk' => Recap::getDefaultFileDisk(),
                'result_file_path' => $path,
            ]);

            $this->donationRecap->state(DonationRecapState::combined);
        }
    }

    public function uniqueId(): string
    {
        return $this->donationRecap->getKey().'|'.$this->donor->getKey();
    }

    public function failed(Throwable $exception): void
    {
        $this->donationRecap->state(DonationRecapState::failure);

        $this->donationRecap->recordHistory($exception->getMessage(), $this->donor->getAttribute('donor_id'));

        \report($exception);
    }
}
