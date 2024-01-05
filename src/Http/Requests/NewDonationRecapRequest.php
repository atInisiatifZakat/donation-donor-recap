<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Inisiatif\DonationRecap\Models\DonationRecapTemplate;

final class NewDonationRecapRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'template_id' => [
                'required', Rule::exists(DonationRecapTemplate::class, 'id'),
            ],
            'start_at' => [
                'required', 'date',
            ],
            'end_at' => [
                'required', 'date',
            ],
        ];
    }
}
