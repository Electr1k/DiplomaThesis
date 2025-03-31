<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Enums\Orders\OrderStatus;
use App\Models\Enums\Orders\PaymentMethod;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courier = Courier::query()->inRandomOrder()->first();
        $payment = fake()->randomFloat(2, 10, 10000);
        return [
            'order_id' => fake()->unique()->numberBetween(4, 1000000),
            'courier_id' => $courier->courier_id,
            'courier_first_name' => $courier->first_name,
            'courier_last_name' => $courier->last_name,
            'courier_middle_name' => $courier->middle_name,
            'payment_method' => PaymentMethod::NONCASH,
            'order_status' => fake()->randomElement(OrderStatus::cases()),
            'order_payment_amount' => $payment,
            'service_commission_amount' => $payment * 0.03,
            'partner_commission_amount' => $payment * 0.03,
            'courier_payment_amount' => $payment * 0.94,
            'courier_additional_payments_amount' => $payment * 0.94,
            'order_accepted_datetime' => fake()->dateTimeBetween($courier->first_order_datetime),
            'order_finished_datetime' => fake()->dateTimeBetween($courier->first_order_datetime),
            'order_first_point_address' => fake()->city(),
            'order_last_point_address'=> fake()->city(),
            'order_lead_time' => fake()->time(),
            'updated_datetime' => fake()->dateTimeBetween($courier->first_order_datetime)
        ];
    }
}
