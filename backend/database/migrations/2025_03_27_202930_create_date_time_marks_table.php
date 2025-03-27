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
        Schema::create('date_time_marks', function (Blueprint $table) {
            $table->comment('Временные метки');

            $table->string('type')
                ->primary()
                ->comment('Тип врменной марки');

            $table->dateTimeTz('date_time')
                ->comment('Дата и время');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_time_marks');
    }
};
