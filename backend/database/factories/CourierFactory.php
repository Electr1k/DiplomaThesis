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


    public function middleNames(): array
    {
        return [
            'Александрович',
            'Дмитриевич',
            'Сергеевич',
            'Андреевич',
            'Алексеевич',
            'Игоревич',
            'Олегович',
            'Владимирович',
            'Иванович',
            'Михайлович',
            'Николаевич',
            'Викторович',
            'Юрьевич',
            'Васильевич',
            'Геннадьевич',
            'Борисович',
            'Павлович',
            'Евгеньевич',
            'Романович',
            'Артёмович'
        ];
    }
}
