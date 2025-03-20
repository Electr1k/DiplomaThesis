<?php

namespace App\Models\Enums;

enum ImportCourierStatusEnum: string
{
    // Клиент добавлен в систему и ожидает создание в Достависто
    case NEW = 'new';

    // Клиент успешно создан в Достависто
    case CREATED = 'created';

    // Ошибка при создаии в Достависто
    case FAILED = 'failed';
}
