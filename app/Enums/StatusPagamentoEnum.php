<?php

namespace App\Enums;

enum StatusPagamentoEnum: string
{
    case PAGO = 'PAGO';
    case PENDENTE = 'PENDENTE';
    case CANCELADO = 'CANCELADO';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}