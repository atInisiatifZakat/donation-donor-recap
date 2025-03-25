<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Inisiatif\DonationRecap\DataTransfers\SendDonorRecapData;

final class SendingDonorRecapJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly SendDonorRecapData $data, private readonly User $user) {}

    public function handle(): void
    {
        $filePath = \sprintf(
            'recaps/donor_list_%s_%s_%s.xls',
            now()->year,
            $this->data->donationRecapId ?? 'unknown',
            Str::random(10)
        );

        // Open file
        $handle = fopen(storage_path("app/$filePath"), 'w');

        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        // Write CSV headers
        fputcsv($handle, [
            'ID Donatur', 'Nama Donatur', 'Cabang', 'Marketing', 'Status',
            'Whatsapp dikirim pada', 'SMS dikirim pada', 'Email dikirim pada'
        ], ';');

        // Write data rows
        foreach ($this->data->data as $recapDonor) {
            fputcsv($handle, [
                $recapDonor['donor_identification_number'],
                $recapDonor['donor_name'],
                $recapDonor['branch_name'],
                $recapDonor['employee_name'],
                $recapDonor['state'],
                $recapDonor['whatsapp_sending_at'],
                $recapDonor['sms_sending_at'],
                $recapDonor['email_sending_at']
            ], ';');
        }

        // Close file
        fclose($handle);

        Storage::disk('local')->put($filePath, file_get_contents(storage_path("app/$filePath")));

        dispatch(new SendingDonorRecap($this->data, $filePath, $this->user));
    }
}

