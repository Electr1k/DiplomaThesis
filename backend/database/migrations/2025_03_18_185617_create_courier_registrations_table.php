<?php

use App\Models\Enums\Couriers\CourierRegistrationStatusEnum;
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
        Schema::create('courier_registrations', function (Blueprint $table) {
            $table->comment('Данные о регистрации курьеров');

            $table->id()
                ->primary()
                ->comment('Идентификатор курьера (внутренний)');

            $table->unsignedBigInteger('courier_id')
                ->nullable()
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

            $table->string('phone')
                ->index()
                ->comment('Телефонный номер курьера');

            $table->string('email')
                ->nullable()
                ->comment('Email курьера');

            $table->date('date_of_birth')
                ->nullable()
                ->comment('Дата рождения');

            $table->string('citizenship')
                ->comment('Гражданство');

            $table->string('passport_number', 10)
                ->nullable()
                ->unique()
                ->comment('Серия и номер паспорта');

            $table->string('status')
                ->comment('Внутренний статус регистрации курьера')
                ->default(CourierRegistrationStatusEnum::NEW);

            $table->text('error_message')
                ->nullable()
                ->comment('Сообщение Достависты, если возникла ошибка');

            $table->foreignId('courier_partner_id')
                ->nullable()
                ->comment('Идентификатор кабинета, которому пренадлежит курьер')
                ->constrained('cabinets', 'courier_partner_id');

            $table->foreignId('user_id')
                ->nullable()
                ->comment('Сотрудник, который привел клиента')
                ->constrained('users', 'id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_registrations');
    }
};
