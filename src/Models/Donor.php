<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

final class Donor extends Model
{
    use HasUuids;
    use Notifiable;

    protected $casts = [
        'notification_channels' => 'array',
    ];

    public function getTable(): string
    {
        return Recap::getDonorTable() ?? parent::getTable();
    }

    public function recaps(): HasManyThrough
    {
        return $this->hasManyThrough(
            DonationRecap::class,
            DonationRecapDonor::class,
            null,
            'id',
            null,
            'donation_recap_id',
        );
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function phone(): BelongsTo
    {
        return $this->belongsTo(Recap::getDonorPhoneClassModel(), 'donor_phone_id')->withoutGlobalScopes();
    }

    public function getPhone(): ?DonorPhone
    {
        return $this->loadMissing('phone')->getRelation('phone');
    }

    public function sendSmsNotification(): bool
    {
        return $this->isSupportedChannels('sms') && !\is_null($this->getPhone());
    }

    public function sendEmailNotification(): bool
    {
        return $this->haveValidEmail() && $this->isSupportedChannels('email');
    }

    public function sendWhatsAppNotification(): bool
    {
        return $this->isSupportedChannels('whatsapp') && $this->getPhone()?->isSupportWhatsApp();
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

    public function getNotificationChannels(): ?array
    {
        $channels = $this->getAttribute('notification_channels');

        if ($channels === null || count($channels) === 0) {
            return ['EMAIL', 'SMS'];
        }

        return $channels;
    }

    public function isSupportedChannels(string $channel): bool
    {
        $channels = $this->getNotificationChannels();

        return $channels === null || \in_array(mb_strtoupper($channel), $channels, true);
    }
}
