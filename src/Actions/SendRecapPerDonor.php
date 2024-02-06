<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\ProcessingState;
use Inisiatif\DonationRecap\Jobs\SendingRecapPerDonor;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\DonationRecap\Exceptions\CannotSendRecap;

final class SendRecapPerDonor
{
    public function handle(DonationRecapDonor $donor): void
    {
        $donor->loadMissing('recap');

        /** @var DonationRecap $recap */
        $recap = $donor->getRelation('recap');

        if ($donor->inState(ProcessingState::combined) === false) {
            throw CannotSendRecap::make('must be in `combined` state');
        }

        \dispatch(new SendingRecapPerDonor($recap, $donor));

        $recap->recordHistory(
            'Memproses pengiriman rekap donasi a/n '.$donor->getAttribute('donor_name'),
            $donor->getAttribute('donor_id')
        );
    }
}
