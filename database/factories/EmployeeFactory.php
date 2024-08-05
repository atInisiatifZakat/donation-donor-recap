<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Database\Factories;

use Illuminate\Foundation\Testing\WithFaker;
use Inisiatif\DonationRecap\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

final class EmployeeFactory extends Factory
{
    use WithFaker;

    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => substr($this->faker->name, 0, 20),
            'email' => $this->faker->safeEmail,
            'address' => $this->faker->address,
            'regency_id' => $this->faker->randomNumber(),
            'city_id' => $this->faker->randomNumber(),
            'province_id' => $this->faker->randomNumber(),
            'postal_code' => $this->faker->postcode,
            'is_marketer' => true,
            'employee_phone_id' => null,
            'branch_id' => $this->faker->uuid(),
        ];
    }
}
