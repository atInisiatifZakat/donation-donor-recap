<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Exceptions;

final class CannotAttachDonor extends \RuntimeException
{
    public static function make(string $id): self
    {
        return new self(
            sprintf('Donor with id `%s` already attach with same template and period', $id)
        );
    }
}
