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
        Schema::create('verify_phones', function (Blueprint $table) {
            $table->id();

            $table->string('phone')
                ->comment('Номер');

            $table->string('ip')
                ->comment('Ip-адрес');

            $table->unsignedSmallInteger('code')
                ->comment('Код');

            $table->unsignedTinyInteger('attempts')
                ->default(0)
                ->comment('Количество неудачных попыток');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verify_phones');
    }
};
