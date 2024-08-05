<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Database\Factories;

use Illuminate\Foundation\Testing\WithFaker;
use Inisiatif\DonationRecap\Enums\ProcessingState;
use Illuminate\Database\Eloquent\Factories\Factory;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class DonationRecapDonorFactory extends Factory
{
    use WithFaker;

    protected $model = DonationRecapDonor::class;

    public function definition(): array
    {
        return [
            'donation_recap_id' => DonationRecapFactory::new(),
            'donor_id' => DonorFactory::new(),
            'donor_name' => $this->faker->name(),
            'donor_identification_number' => $this->faker->randomNumber(5, true),
            'donor_phone_number' => $this->faker->phoneNumber(),
            'donor_tax_number' => $this->faker->randomNumber(3, true),
            'donor_address' => $this->faker->address(),
            'state' => ProcessingState::new,
            'disk' => 'local',
            'result_disk' => 'local',
            'result_file_path' => $this->faker->filePath()
        ];
    }
}
