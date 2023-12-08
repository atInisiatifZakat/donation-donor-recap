<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Traits;

trait HasQueueConfig
{
    public static function getQueueConnection(): string
    {
        return \config('recap.queue.connection');
    }

    public static function getQueueName(): string
    {
        return \config('recap.queue.name');
    }
}
