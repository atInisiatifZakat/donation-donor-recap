<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Enums;

enum DonationRecapState: string
{
    case new = 'new';
    case processing = 'processing';
    case processed = 'processed';
    case done = 'done';
    case failure = 'failure';
}
