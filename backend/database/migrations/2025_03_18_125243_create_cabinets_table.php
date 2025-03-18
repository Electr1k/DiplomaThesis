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
        Schema::create('cabinets', function (Blueprint $table) {
            $table->comment('Кабинеты парнеров');

            $table->bigInteger('courier_partner_id')
                ->primary()
                ->unique()
                ->comment('Идентификатор кабинета партнера');

            $table->string('region_name')
                ->comment('Регион партнёра');

            $table->string('vehicle_type_name')
                ->comment('Тип транспорта партнёра');

            $table->string('legal_name')
                ->comment('Наименование юридического лица');

            $table->float('partner_commission_part')
                ->comment('Процент комиссии партнёра');

            $table->boolean('is_for_taking_available_couriers')
                ->comment('Особый кабинет для особых курьеров');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinets');
    }
};
