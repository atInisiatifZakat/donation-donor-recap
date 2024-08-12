<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Database\Factories;

use Illuminate\Foundation\Testing\WithFaker;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Illuminate\Database\Eloquent\Factories\Factory;
use Inisiatif\DonationRecap\Enums\DonationRecapState;

final class DonationRecapFactory extends Factory
{

    use WithFaker;

    protected $model = DonationRecap::class;

    public function definition(): array
    {
        return [
            'template_id' => DonationRecapTemplateFactory::new(),
            'user_id' => $this->faker->randomDigit(),
            'start_at' => $this->faker->date(),
            'end_at' => $this->faker->date(),
            'count_total' => 0,
            'count_progress' => 0,
            'last_send_at' => null,
            'state' => DonationRecapState::new,
        ];
    }
}
