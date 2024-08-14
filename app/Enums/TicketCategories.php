<?php

namespace App\Enums;

enum TicketCategories: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
    case EARNING = 'earning';
    case REFERRAL = 'referral';
    case ACCOUNT = 'account';
    case OTHERS = 'Others';
}
