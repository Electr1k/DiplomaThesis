<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\Enums\Transactions\TransactionStatus;
use App\Models\Enums\Transactions\TransactionType;
use App\Models\Order;
use App\Models\Transaction;
use Carbon\Carbon;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $courier = Courier::factory()->createOne();

            Order::factory(20)->create([
                'courier_id' => $courier->courier_id,
                'order_accepted_datetime' => fake()->dateTimeBetween($courier->first_order_datetime),
                'order_finished_datetime' => fake()->dateTimeBetween($courier->first_order_datetime),
                'updated_datetime' => fake()->dateTimeBetween($courier->first_order_datetime)
            ]);


            Transaction::factory(20)->create([
                'courier_id' => $courier->courier_id,
                'updated_datetime' => fake()->dateTimeBetween($courier->first_order_datetime),
            ]);
        }
    }


}
/// php artisan db:seed --class=CourierSeeder
