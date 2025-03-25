<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SendDonorRecapRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'donation_recap_id' => ['required', 'string'],
            'template_name' => ['required', 'string'],
            'start_at' => ['required', 'string'],
            'end_at' => ['required', 'string'],
            'donation_recap_state' => ['required', 'string'],
            'filter' => ['nullable', 'array'],
            'filter.donor_identification_number' => ['nullable', 'string'],
            'filter.donor_name' => ['nullable', 'string'],
            'filter.donor_phone' => ['nullable', 'string'],
            'data' => ['required', 'array'],
            'data.*donor_identification_number' => ['required', 'string'],
            'data.*donor_name' => ['required', 'string'],
            'data.*branch_name' => ['required', 'string'],
            'data.*employee_name' => ['required', 'string'],
            'data.*state' => ['required', 'string'],
            'data.*whatsapp_sending_at' => ['required', 'string'],
            'data.*sms_sending_at' => ['required', 'string'],
            'data.*email_sending_at' => ['required', 'string'],
        ];
    }
}
