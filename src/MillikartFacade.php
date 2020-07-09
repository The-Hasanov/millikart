<?php

namespace Chameleon\Millikart;

use Illuminate\Support\Facades\Facade;

class MillikartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Millikart::class;
    }
}
