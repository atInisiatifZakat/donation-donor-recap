<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Database\Factories;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Inisiatif\DonationRecap\Models\DonationRecapTemplate;

final class DonationRecapTemplateFactory extends Factory
{
    use WithFaker;

    protected $model = DonationRecapTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'disk' => 'local',
            'suffix_file_path' => 'first-page.pdf',
            'prefix_file_path' => 'last-page.pdf',
            'is_active' => true,
        ];
    }
}
