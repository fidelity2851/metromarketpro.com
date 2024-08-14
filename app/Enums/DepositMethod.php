<?php

namespace App\Enums;

enum DepositMethod: string
{
    case CRYPTO = 'Crypto';
    case WIRE_TRANSFER = 'Wire Transfer';
}

