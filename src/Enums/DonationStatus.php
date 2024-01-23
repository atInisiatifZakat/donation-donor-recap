<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Enums;

enum DonationStatus: string
{
    case pending = 'PENDING';

    case verified = 'VERIFIED';

    case cancel = 'CANCEL';
}
