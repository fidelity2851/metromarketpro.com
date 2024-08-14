<?php

namespace App\Enums;

enum Maturity: string
{
    case DAY = '1';
    case WEEK = '7';
    case MONTH = '30';
    case YEAR = '365';
}

