<?php

namespace App\Enums;

enum StatusPedidoEnum: string
{
    case PREPARANDO = 'PREPARANDO';
    case PRONTO = 'PRONTO';
    case ENTREGUE = 'ENTREGUE';
    case CANCELADO = 'CANCELADO';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}