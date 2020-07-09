<?php

namespace Chameleon\Millikart\Operation;

use Chameleon\Millikart\Builder;
use Chameleon\Millikart\Element;

class GetOrderStatus extends Builder
{
    /**
     * Operation Name.
     */
    public const OPERATION = 'GetOrderStatus';

    /**
     * GetOrderStatus constructor.
     */
    public function __construct()
    {
        $this->operation(self::OPERATION);
    }

    /**
     * @param $orderID
     * @return GetOrderStatus
     */
    public function orderId($orderID): GetOrderStatus
    {
        return $this->setElementInOrder(Element::ORDER_ID, $orderID);
    }

    /**
     * @param $sessionID
     * @return GetOrderStatus
     */
    public function sessionID($sessionID): GetOrderStatus
    {
        return $this->setElementInRequest(Element::SESSION_ID, $sessionID);
    }

}
