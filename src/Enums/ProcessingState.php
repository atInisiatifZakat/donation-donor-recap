<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Enums;

enum ProcessingState: string
{
    case new = 'new';
    case collecting = 'collecting';

    case collected = 'collected';

    case generating = 'generating';

    case generated = 'generated';

    case combining = 'combining';

    case combined = 'combined';

}
