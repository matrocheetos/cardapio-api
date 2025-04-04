<?php

namespace App\Enum;

enum StatusPedido: string
{
    case PREPARANDO = 'PREPARANDO';
    case PRONTO = 'PRONTO';
    case ENTREGUE = 'ENTREGUE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}