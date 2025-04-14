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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Пользователи');

            $table->id()
                ->comment('Идентификатор пользователя');

            $table->string('name')
                ->comment('Имя');

            $table->string('surname')
                ->comment('Фамилия');

            $table->string('middle_name')
                ->nullable()
                ->comment('Отчество');

            $table->string('email')
                ->unique()
                ->comment('Email');

            $table->string('password')
                ->comment('Хешированный пароль');

            $table->string('image')
                ->nullable()
                ->comment('Фото профиля');

            $table->foreignId('role_id')
                ->comment('Идентификатор роли')
                ->constrained('roles', 'id');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
