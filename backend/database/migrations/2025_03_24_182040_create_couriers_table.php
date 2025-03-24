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
        Schema::create('couriers', function (Blueprint $table) {
            $table->comment('Курьеры');

            $table->unsignedBigInteger('courier_id')
                ->primary()
                ->index()
                ->comment('Идентификатор курьера в Достависта');

            $table->string('name')
                ->nullable()
                ->comment('Имя курьера');

            $table->string('surname')
                ->nullable()
                ->comment('Фамилия курьера');

            $table->string('middle_name')
                ->nullable()
                ->comment('Отчество курьера');

            $table->string('status')
                ->comment('Статус курьера');

            $table->dateTimeTz('ban_end_datetime')
                ->nullable()
                ->comment('Дата и время окончания бана курьера');

            $table->string('phone')
                ->index()
                ->nullable()
                ->comment('Телефон');

            $table->dateTimeTz('registered_datetime')
                ->comment('Дата и время регистрации курьера');

            $table->dateTimeTz('updated_datetime')
                ->nullable()
                ->comment('Дата и время последнего изменения данных курьера');

            $table->unsignedInteger('orders_completed_count')
                ->comment('Количество выполненных заказов курьером у данного партнёра');

            $table->dateTimeTz('first_order_datetime')
                ->nullable()
                ->comment('Дата и время выполнения первого заказа курьером у данного партнёра');

            $table->dateTimeTz('last_order_datetime')
                ->nullable()
                ->comment('Дата и время выполнения последнего заказа курьером у данного партнёра');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
