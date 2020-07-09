<?php

namespace Chameleon\Millikart;

use Illuminate\Support\Arr;

class Response
{
    /**
     * Statuses
     */
    public const STATUS = [
        'SUCCESS'                => '00',
        'INVALID_MESSAGE_FORMAT' => '30',
        'NO_ACCESS'              => '10',
        'INVALID_OPERATION'      => '54',
        'EMPTY_RESPONSE'         => '72',
        'SYSTEM_ERROR'           => '96',
        'CONNECTION_ERROR'       => '97',
    ];

    /**
     * Messages
     */
    public const STATUS_MESSAGE = [
        '00' => 'Successfully',
        '30' => 'Invalid message format (no mandatory parameters etc.)',
        '10' => 'Internet shop has no access to the operation (or the Internet shop is not registered)',
        '54' => 'Invalid operation',
        '72' => 'Empty POS driver response',
        '96' => 'System error',
        '97' => 'POS driver connection error',
    ];
    /**
     * Order Statuses
     */
    public const ORDER_STATUS = [
        'CREATED'  => 'CREATED',
        'APPROVED' => 'APPROVED',
        'CANCELED' => 'CANCELED',
        'DECLINED' => 'DECLINED',
        'EXPIRED'  => 'EXPIRED',
        'ERROR'    => 'ERROR',
    ];

    /**
     * @var array
     */
    private $elements;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return string|null
     */
    public function operation(): ?string
    {
        return $this->getInResponse(Element::OPERATION);
    }


    /**
     * @return string|null
     */
    public function status(): ?string
    {
        return $this->getInResponse(Element::STATUS);
    }

    /**
     * @return string|null
     */
    public function statusMessage()
    {
        return ($status = $this->status()) !== null && array_key_exists($status, self::STATUS_MESSAGE)
            ? self::STATUS_MESSAGE[$status]
            : 'Unknown';
    }

    /**
     * @return array|null
     */
    public function order(): ?array
    {
        return $this->getInResponse(Element::ORDER);
    }

    /**
     * @return string|null
     */
    public function orderId(): ?string
    {
        return $this->getInOrder(Element::ORDER_ID);
    }

    /**
     * @return string|null
     */
    public function orderStatus(): ?string
    {
        return $this->getInOrder(Element::ORDER_STATUS);
    }

    /**
     * @return string|null
     */
    public function sessionId(): ?string
    {
        return $this->getInOrder(Element::SESSION_ID);
    }


    /**
     * @return string|null
     */
    public function url(): ?string
    {
        return $this->getInOrder(Element::URL);
    }

    /**
     * @return string|null
     */
    public function redirectUrl(): ?string
    {
        if ($url = $this->url()) {
            return $this->url() . '?' . http_build_query([
                    Element::ORDER_ID   => $this->orderId(),
                    Element::SESSION_ID => $this->sessionId()
                ]);
        }
        return null;
    }

    /**
     * @param $element
     * @return string|array|null
     */
    public function getInResponse($element)
    {
        return Arr::get($this->elements, Element::tree(Element::ROOT, Element::RESPONSE, $element));
    }

    /**
     * @param $element
     * @return string|array|null
     */
    private function getInOrder($element)
    {
        return Arr::get($this->elements, Element::tree(Element::ROOT, Element::RESPONSE, Element::ORDER, $element));
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return array_key_exists(Element::ROOT, $this->elements)
            ? $this->elements[Element::ROOT]
            : $this->elements;
    }

    public function toArray(): array
    {
        return $this->elements;
    }
}
