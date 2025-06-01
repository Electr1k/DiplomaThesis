<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Enums\Couriers\CourierStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для генерации случайного курьера
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
{
    use RussianNameTrait;

    /** Переопределяемый метод с значением полей */
    public function definition(): array
    {
        $registration = fake()->dateTimeBetween('-1 month');
        $first_order = fake()->dateTimeBetween($registration);
        return [
            'courier_id' => fake()->unique()->numberBetween(4, 1000000),
            'name' => fake()->randomElement($this->firstNames()),
            'surname' => fake()->randomElement($this->surnames()),
            'middle_name' => fake()->randomElement($this->middleNames()),
            'status' => fake()->randomElement(CourierStatus::cases()),
            'ban_end_datetime' => null,
            'phone' => '+79' . fake()->numberBetween(100000000, 999999999),
            'registered_datetime' => $registration,
            'updated_datetime' => $registration,
            'orders_completed_count' => fake()->numberBetween(0, 100),
            'first_order_datetime' => $first_order,
            'last_order_datetime' => fake()->dateTimeBetween($first_order)
        ];
    }

}
