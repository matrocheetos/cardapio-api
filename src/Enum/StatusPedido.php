<?php

namespace App\Enum;

enum StatusPedido: string
{
    case PREPARANDO = 'PREPARANDO';
    case PRONTO = 'PRONTO';
    case ENTREGUE = 'ENTREGUE';
}