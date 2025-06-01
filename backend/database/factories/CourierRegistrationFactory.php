<?php

namespace Database\Factories;

use App\Models\Cabinet;
use App\Models\Courier;
use App\Models\Enums\Couriers\Citizenship;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для генерации случайной регистрации
 * @extends Factory<Courier>
 */
class CourierRegistrationFactory extends Factory
{
    use RussianNameTrait;

    /** Переопределяемый метод с значением полей */
    public function definition(): array
    {
        return [
            'courier_id' => fake()->numberBetween(0, 1000),
            'name' => fake()->randomElement($this->firstNames()),
            'surname' => fake()->randomElement($this->surnames()),
            'middle_name'=> fake()->randomElement($this->middleNames()),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'date_of_birth' => fake()->dateTime(),
            'citizenship' => fake()->randomElement(Citizenship::cases()),
            'passport_number' => fake()->numberBetween(1000000000, 9999999999),
            'courier_partner_id' => Cabinet::factory(),
            'user_id' => null,
            'error_message' => null,
        ];
    }

}
