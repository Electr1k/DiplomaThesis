<?php

namespace App\Models\Enums\Couriers;

enum CourierStatus: string
{
    // Одобрен и работает у партнёра
    case APPROVED = 'approved';

    // Привязан к партнёру, но забанен
    case BANNED = 'banned';

    // Привязан к партнёру, но аккаунт удалён
    case DELETED = 'deleted';

    // Никогда не работал у партнёра
    case NEVER_WORKED = 'never_worked';

    // Привязан к партнёру, ожидает одобрения
    case RETIRED = 'retired';

    public function title(): string
    {
        return match ($this) {
            self::APPROVED => 'Одобрен и работает у партнёра',
            self::BANNED => 'Привязан к партнёру, но забанен',
            self::DELETED => 'Привязан к партнёру, но аккаунт удалён',
            self::NEVER_WORKED => 'Никогда не работал у партнёра',
            self::RETIRED => 'Привязан к партнёру, ожидает одобрения'
        };
    }
}
