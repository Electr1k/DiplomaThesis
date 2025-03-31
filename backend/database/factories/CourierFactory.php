<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Enums\Couriers\CourierStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $registration = fake()->dateTimeBetween('-1 month');
        $first_order = fake()->dateTimeBetween($registration);
        return [
            'courier_id' => fake()->unique()->numberBetween(4, 1000000),
            'name' => fake()->name(),
            'surname' => fake()->name(),
            'middle_name' => fake()->name(),
            'status' => fake()->randomElement(CourierStatus::cases()),
            'ban_end_datetime' => null,
            'phone' => fake()->phoneNumber(),
            'registered_datetime' => $registration,
            'updated_datetime' => $registration,
            'orders_completed_count' => fake()->numberBetween(0, 100),
            'first_order_datetime' => $first_order,
            'last_order_datetime' => fake()->dateTimeBetween($first_order)
        ];
    }
}
