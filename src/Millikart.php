<?php

namespace Chameleon\Millikart;

use Chameleon\Millikart\Operation\CreateOrder;
use Chameleon\Millikart\Operation\GetOrderInformation;
use Chameleon\Millikart\Operation\GetOrderStatus;

class Millikart
{
    private static $builderPrepare;

    private $api;

    public function __construct(MillikartApi $api)
    {
        $this->api = $api;
    }

    public function createOrder(\Closure $builderCallback)
    {
        return $this->send($this->prepareBuild(new CreateOrder(), $builderCallback));
    }

    public function getOrderStatus(\Closure $builderCallback)
    {
        return $this->send($this->prepareBuild(new GetOrderStatus(), $builderCallback));
    }

    public function getOrderInformation(\Closure $builderCallback)
    {
        return $this->send($this->prepareBuild(new GetOrderInformation(), $builderCallback));
    }

    public static function beforeBuild(\Closure $default)
    {
        static::$builderPrepare = $default;
    }

    private function prepareBuild(Builder $builder, \Closure $builderCallback)
    {
        if (is_callable(static::$builderPrepare)) {
            $builder = (static::$builderPrepare)($builder) ?? $builder;
        }

        return $builderCallback($builder) ?? $builder;
    }

    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param Builder $builder
     * @return Response
     */
    public function send(Builder $builder)
    {
        return $this->api->request($builder->toArray());
    }
}
