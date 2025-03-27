<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->comment('Заказы');

            $table->unsignedBigInteger('order_id')
                ->primary()
                ->comment('Идентификатор заказа');

            $table->unsignedBigInteger('courier_id')
                ->index()
                ->comment('Идентификатор курьера');

            $table->string('courier_first_name')
                ->nullable()
                ->comment('Имя курьера');

            $table->string('courier_last_name')
                ->nullable()
                ->comment('Фамилия курьера');

            $table->string('courier_middle_name')
                ->nullable()
                ->comment('Отчество курьера');

            $table->string('payment_method')
                ->comment('Метод оплаты заказа');

            $table->string('order_status')
                ->comment('Статус заказа');

            $table->float('order_payment_amount')
                ->comment('Сумма пополнения');

            $table->float('service_commission_amount')
                ->comment('Комиссия Достависты');

            $table->float('partner_commission_amount')
                ->comment('Комиссия партнера');

            $table->float('courier_payment_amount')
                ->comment('Курьерское вознаграждение');

            $table->float('courier_additional_payments_amount')
                ->comment('Компенсации минус штрафы');

            $table->dateTimeTz('order_accepted_datetime')
                ->comment('Дата и время назначения курьера на заказ');

            $table->dateTimeTz('order_finished_datetime')
                ->index()
                ->comment('Дата и время выполнения заказа курьером');

            $table->string('order_first_point_address')
                ->comment('Адрес первой точки');

            $table->string('order_last_point_address')
                ->comment('Адрес последней точки');

            $table->time('order_lead_time')
                ->comment('Продолжительность выполнения заказа');

            $table->dateTimeTz('updated_datetime')
                ->index()
                ->comment('Время изменения данных модели');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
