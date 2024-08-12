<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Database\Factories;

use Inisiatif\DonationRecap\Models\Donor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DonorFactory extends Factory
{
    use WithFaker;

    protected $model = Donor::class;

    public function definition(): array
    {
        return [
            'identification_number' => $this->faker->uuid,
            'branch_id' => $this->faker->uuid,
            'employee_id' => $this->faker->uuid,
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'notification_channels' => ["EMAIL"],
        ];
    }
}
