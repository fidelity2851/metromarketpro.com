<?php

namespace App\Enums;

enum InterestPeriod: string
{
    case HOURLY = '0.0416666666666667';
    case DAILY = '1';
    case WEEKLY = '7';
    case MONTHLY = '30';
    case ANNUALLY = '365';
}
