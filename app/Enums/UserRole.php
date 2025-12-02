<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case VERIFIKATOR = 'verifikator';
    case USER = 'user';
}