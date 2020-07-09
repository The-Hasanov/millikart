<?php

namespace Chameleon\Millikart\Operation;

use Chameleon\Millikart\Builder;
use Chameleon\Millikart\Element;

class CreateOrder extends Builder
{
    /**
     * Operation Name.
     */
    public const OPERATION = 'CreateOrder';

    /**
     * CreateOrder constructor.
     */
    public function __construct()
    {
        $this->operation(self::OPERATION);
        $this->setElementInOrder(Element::ORDER_TYPE, 'Purchase');
    }

    /**
     * @param int|double $amount
     * @param bool       $toMinorUnit
     * @return CreateOrder
     */
    public function amount($amount, $toMinorUnit = true): CreateOrder
    {
        if ($toMinorUnit) {
            $amount *= 100;
        }
        return $this->setElementInOrder(Element::AMOUNT, (int)$amount);
    }

    /**
     * @param string $isoCode
     * @return CreateOrder
     */
    public function currency($isoCode): CreateOrder
    {
        return $this->setElementInOrder(Element::CURRENCY, $isoCode);
    }

    /**
     * @param string $description
     * @return CreateOrder
     */
    public function description($description): CreateOrder
    {
        return $this->setElementInOrder(Element::DESCRIPTION, $description);
    }

    /**
     * @param string $url
     * @return  CreateOrder
     */
    public function approveUrl($url): CreateOrder
    {
        return $this->setElementInOrder(Element::APPROVE_URL, $url);
    }

    /**
     * @param string $url
     * @return CreateOrder
     */
    public function cancelUrl($url): CreateOrder
    {
        return $this->setElementInOrder(Element::CANCEL_URL, $url);
    }

    /**
     * @param string $url
     * @return CreateOrder
     */
    public function declineUrl($url): CreateOrder
    {
        return $this->setElementInOrder(Element::DECLINE_URL, $url);
    }

    /**
     * @param string $url
     * @return CreateOrder
     */
    public function allUrl($url)
    {
        $this->approveUrl($url);
        $this->cancelUrl($url);
        $this->declineUrl($url);
        return $this;
    }
}
