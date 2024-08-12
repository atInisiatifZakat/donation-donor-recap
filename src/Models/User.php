<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Inisiatif\DonationRecap\DonationRecap as Recap;

final class User extends Model
{
    use HasUuids;
    use SoftDeletes;

    public function getTable(): string
    {
        return Recap::getUserTableName() ?? parent::getTable();
    }

    public function getEmail(): ?string
    {
        return $this->getAttribute('email');
    }

    public function haveValidEmail(): bool
    {
        try {
            Assert::email($this->getEmail());

            return true;
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }
}
