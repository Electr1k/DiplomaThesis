<?php

namespace App\Models\Enums;

enum DateTimeMarkType: string
{
    case LAST_IMPORT_ORDERS = 'last_import_orders';

    case LAST_IMPORT_TRANSACTIONS = 'last_import_transactions';
}
