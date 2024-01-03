<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Traits;

trait HasFileStorageConfig
{
    public static function getDefaultFileDisk(): string
    {
        return \config('recap.file.disk');
    }

    public static function getDefaultFileUrl(): ?string
    {
        return \config('recap.file.disk_url');
    }

    public static function getFileGeneratedBasePath(): string
    {
        return \config('recap.file.generated');
    }

    public static function getFileResultBasePath(): string
    {
        return \config('recap.file.result');
    }
}
