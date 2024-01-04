<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Traits;

trait HasNotificationConfig
{
    public static function getMailSenderAddress(): string
    {
        return \config('recap.notification.email.sender_address');
    }

    public static function getMailSenderName(): string
    {
        return \config('recap.notification.email.sender_name');
    }

    public static function getWhatsAppChannelId(): string
    {
        return \config('recap.notification.whatsapp.channel_id');
    }

    public static function getWhatsAppTemplateId(): string
    {
        return \config('recap.notification.whatsapp.template_id');
    }
}
