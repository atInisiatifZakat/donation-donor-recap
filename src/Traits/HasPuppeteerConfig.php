<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Traits;

trait HasPuppeteerConfig
{
    public static function getNodeBinaryPath(): string
    {
        return \config('recap.puppeteer.node');
    }

    public static function getNpmBinaryPath(): string
    {
        return \config('recap.puppeteer.npm');
    }
}
