<?php

namespace Database\Factories;

use App\Models\Cabinet;
use App\Models\Enums\Cabinet\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cabinet>
 */
class CabinetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'courier_partner_id' => $this->faker->unique()->numberBetween(4, 1000000),
            'region_name' => $this->faker->unique()->randomElement(['Москва', 'Санкт-Петербург', 'Сочи', 'Ростов-на-Дону', 'Таганрог', 'Краснодар']),
            'vehicle_type_name' => $this->faker->randomElement(VehicleType::cases())->value,
            'legal_name' => $this->faker->randomElement($this->firstNames()) . ' ' . $this->faker->randomElement($this->surnames()),
            'partner_commission_part' => 0.03,
            'is_for_taking_available_couriers' => $this->faker->boolean(),
        ];
    }

    public function firstNames(): array
    {
        return [
            'Александр',
            'Дмитрий',
            'Максим',
            'Сергей',
            'Андрей',
            'Алексей',
            'Артём',
            'Илья',
            'Кирилл',
            'Михаил',
            'Никита',
            'Матвей',
            'Роман',
            'Егор',
            'Арсений',
            'Иван',
            'Денис',
            'Евгений',
            'Даниил',
            'Тимофей'
        ];
    }

    public function surnames(): array
    {
        return [
            'Иванов',
            'Петров',
            'Сидоров',
            'Смирнов',
            'Кузнецов',
            'Васильев',
            'Попов',
            'Соколов',
            'Михайлов',
            'Новиков',
            'Фёдоров',
            'Морозов',
            'Волков',
            'Алексеев',
            'Лебедев',
            'Семёнов',
            'Егоров',
            'Павлов',
            'Козлов',
            'Степанов'
        ];
    }
}
