<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\ProcessingState;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class ReprocessDonationRecapDonor implements ShouldBeUnique, ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly DonationRecap $donationRecap,
        public readonly DonationRecapDonor $donor
    ) {}

    public function handle(): void
    {
        $this->donor->state(ProcessingState::new);

        $this->donationRecap->recordHistory(
            \sprintf('Memproses ulang pembuatan rekap donasi untuk %s', $this->donor->getAttribute('donor_name'))
        );

        $jobChains = [
            new ClearDonationRecapDetail($this->donationRecap, $this->donor),
            new BuildDonationRecapDetail($this->donationRecap, $this->donor),
            new GenerateDonorRecapFile($this->donationRecap, $this->donor),
            new CombineDonorRecapFile($this->donationRecap, $this->donor),
        ];

        $this->dispatchChain($jobChains);
    }

    public function uniqueId(): string
    {
        return $this->donationRecap->getKey().'-'.$this->donor->getKey();
    }

    protected function dispatchChain(array $jobs): void
    {
        $connectionName = Recap::getQueueConnection();

        $queueName = Recap::getQueueName();

        Bus::chain($jobs)->onConnection($connectionName)->onQueue($queueName)->dispatch();
    }
}
