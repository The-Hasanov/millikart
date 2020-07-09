<?php

namespace Chameleon\Millikart\Operation;

use Chameleon\Millikart\Builder;
use Chameleon\Millikart\Element;

class GetOrderInformation extends Builder
{
    /**
     * Operation Name.
     */
    public const OPERATION = 'GetOrderInformation';

    /**
     * GetOrderStatus constructor.
     */
    public function __construct()
    {
        $this->operation(self::OPERATION);
    }

    /**
     * @param $orderID
     * @return self
     */
    public function orderId($orderID): self
    {
        return $this->setElementInOrder(Element::ORDER_ID, $orderID);
    }

    /**
     * @param $sessionID
     * @return GetOrderStatus
     */
    public function sessionID($sessionID): self
    {
        return $this->setElementInRequest(Element::SESSION_ID, $sessionID);
    }

    public function showParams(bool $show): self
    {
        return $this->setElementInRequest(Element::SHOW_PARAMS, $show);
    }

    public function showOperations(bool $show): self
    {
        return $this->setElementInRequest(Element::SHOW_OPERATIONS, $show);
    }

}
