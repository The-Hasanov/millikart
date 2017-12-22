<?php

namespace Chameleon;

use Illuminate\Support\Facades\Facade;

/**
 * Class MilliKartFacade
 * @package Chameleon
 */
class MilliKartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'millikart';
    }
}
