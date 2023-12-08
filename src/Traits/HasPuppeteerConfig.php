<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Traits;

trait HasPuppeteerConfig
{
    public static function getPaperSizeFormat(): string
    {
        return \config('recap.puppeteer.paper_size_format', 'Letter');
    }

    public static function getNodeBinaryPath(): string
    {
        return \config('recap.puppeteer.node');
    }

    public static function getNpmBinaryPath(): string
    {
        return \config('recap.puppeteer.npm');
    }
}
