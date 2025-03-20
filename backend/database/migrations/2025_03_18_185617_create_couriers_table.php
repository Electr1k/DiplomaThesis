<?php

use App\Models\Enums\ImportCourierStatusEnum;
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

            $table->string('middlename')
                ->nullable()
                ->comment('Отчество курьера');

            $table->string('phone')
                ->comment('Телефонный номер курьера');

            $table->string('email')
                ->nullable()
                ->comment('Email курьера');

            $table->date('date_of_birth')
                ->nullable()
                ->comment('Дата рождения');

            $table->string('citizenship')
                ->comment('Гражданство');

            $table->foreignId('courier_partner_id')
                ->nullable()
                ->comment('Идентификатор кабинета, которому пренадлежит курьер')
                ->constrained('cabinets', 'courier_partner_id');

            $table->string('status')
                ->comment('Внутренний статус регистрации курьера')
                ->default(ImportCourierStatusEnum::NEW);

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
