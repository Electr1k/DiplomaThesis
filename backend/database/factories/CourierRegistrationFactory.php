<?php

namespace Database\Factories;

use App\Models\Cabinet;
use App\Models\Courier;
use App\Models\Enums\Couriers\Citizenship;
use App\Models\Enums\Couriers\CourierStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Courier>
 */
class CourierRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
