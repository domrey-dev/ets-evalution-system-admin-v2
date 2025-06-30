<?php

namespace App\Constants;

use ReflectionClass;

class ConstUserRole
{
    const ADMIN = 'admin';
    const DEPARTMENT = 'department';
    const USER = 'user';

    /**
     * Get all constants
     */
    public static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}
