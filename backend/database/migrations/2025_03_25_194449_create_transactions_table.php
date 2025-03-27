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
        Schema::create('transactions', function (Blueprint $table) {
            $table->comment('Транзакции');

            $table->unsignedBigInteger('transaction_id')
                ->primary()
                ->comment('Идентификатор транзакции');

            $table->unsignedBigInteger('courier_id')
                ->index()
                ->comment('Идентификатор курьера');

            $table->unsignedBigInteger('order_id')
                ->index()
                ->nullable()
                ->comment('Идентификатор заказа');

            $table->string('transaction_type')
                ->comment('Тип транзакции');

            $table->float('amount')
                ->comment('Сумма транзакции');

            $table->float('partner_commission_amount')
                ->comment('Комиссия партнера');

            $table->float('courier_payment_amount')
                ->comment('Курьерское вознаграждение');

            $table->dateTimeTz('updated_datetime')
                ->index()
                ->comment('Время изменения транзакции');

            $table->unsignedBigInteger('rollback_transaction_id')
                ->nullable()
                ->comment('Идентификатор отмененной транзакции');

            $table->string('transaction_status')
                ->comment('Статус отката транзакции.');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
