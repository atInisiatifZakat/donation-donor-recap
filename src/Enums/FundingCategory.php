<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Enums;

enum FundingCategory: int
{
    case zakat = 1;

    case infaq = 2;

    case wakaf = 3;

    case qurban = 4;

    case nonHalal = 5;
}
