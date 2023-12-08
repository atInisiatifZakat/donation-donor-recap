<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Enums;

enum DonationRecapState: string
{
    case new = 'new';

    case failure = 'failure';

    case collecting = 'collecting';

    case collected = 'collected';

    case generating = 'generating';

    case generated = 'generated';

    case combining = 'combining';

    case combined = 'combined';
}
