<?php

declare(strict_types=1);

namespace Database\Factories\Profile;

use App\Enums\Employer\Funding;
use App\Enums\Employer\Type;
use App\Models\City;
use App\Models\ProfileEmployer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfileEmployer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $city = City::query()->inRandomOrder()->first();

        return [
            'name' => fake()->company(),
            'type' => fake()->randomElement(Type::values()),
            'funding' => fake()->randomElement(Funding::values()),
            'start_date' => fake()->date(),
            'county_id' => $city->county_id,
            'city_id' => $city->id,
            'email' => fake()->boolean() ? fake()->safeEmail() : null,
            'phone' => fake()->boolean() ? fake()->phoneNumber() : null,
        ];
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => Carbon::parse($attributes['start_date'])
                ->addMonths(fake()->randomDigitNotNull()),
        ]);
    }

    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => fake()->date(),
            'end_date' => null,
        ]);
    }

    public function withProject(): static
    {
        return $this->state(fn (array $attributes) => [
            'project' => fake()->sentence(),
        ]);
    }

    public function withGPAgreement(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_gp_agreement' => true,
            'gp_name' => fake()->name(),
            'gp_email' => fake()->safeEmail(),
            'gp_phone' => fake()->phoneNumber(),
        ]);
    }
}
