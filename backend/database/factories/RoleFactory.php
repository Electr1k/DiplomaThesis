<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для генерации случайной роли
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /** Переопределяемый метод с значением полей */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }

}
