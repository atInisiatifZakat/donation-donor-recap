<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Exceptions;

final class CannotSendRecap extends \RuntimeException
{
    public static function make(string $reason): self
    {
        return new self(
            sprintf('Cannot send recap : %s', $reason)
        );
    }
}
