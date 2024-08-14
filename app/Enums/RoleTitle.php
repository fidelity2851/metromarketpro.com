<?php

namespace App\Enums;

enum RoleTitle: string
{
    case ADMIN = 'Admin';
    case TEAM = 'Team';
    case USER = 'Client';
}

