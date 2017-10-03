<?php

namespace Chameleon;

use Illuminate\Support\Facades\Facade;

class MilliKartFacade extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'millikart';
    }

}