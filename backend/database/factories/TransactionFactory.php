<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Enums\Transactions\TransactionStatus;
use App\Models\Enums\Transactions\TransactionType;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courier = Courier::query()->inRandomOrder()->first();
        $amount = fake()->randomFloat(2, 10, 10000);

        return [
            'transaction_id' => fake()->unique()->numberBetween(4, 1000000),
            'courier_id' => $courier->courier_id,
            'order_id' => null,
            'transaction_type' => fake()->randomElement(TransactionType::cases()),
            'amount' => $amount,
            'partner_commission_amount' => $amount,
            'courier_payment_amount' => $amount,
            'updated_datetime' => fake()->dateTimeBetween($courier->first_order_datetime),
            'rollback_transaction_id' => null,
            'transaction_status' => TransactionStatus::ACTIVE,
        ];
    }
}
