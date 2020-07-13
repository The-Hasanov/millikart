<?php

namespace Chameleon\Millikart;

use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

abstract class Builder
{
    use Macroable;
    /**
     *  Most used ISO 4217 codes
     */
    public const CURRENCY = [
        'AZN' => '944',
        'EUR' => '978',
        'GEL' => '981',
        'RUB' => '643',
        'TRY' => '949',
        'USD' => '840',
    ];
    /**
     * Available Languages
     */
    public const LANGUAGE = [
        'AZ' => 'az',
        'EN' => 'en',
        'RU' => 'ru',
    ];
    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @param string $operation
     * @return static
     */
    protected function operation($operation)
    {
        return $this->setElementInRequest(Element::OPERATION, $operation);
    }

    /**
     * @param string $language
     * @return static
     */
    public function language($language)
    {
        $this->setElementInRequest(Element::LANGUAGE, strtoupper($language));
        return $this;
    }

    /**
     * @param string $merchant
     * @return static
     */
    public function merchant($merchant)
    {
        return $this->setElementInOrder(Element::MERCHANT, $merchant);
    }

    /**
     * @param $element
     * @param $value
     * @return static
     */
    protected function setElement($element, $value)
    {
        $this->elements[$element] = $value;
        return $this;
    }

    /**
     * @param $element
     * @param $value
     * @return static
     */
    protected function setElementInRequest($element, $value)
    {
        return $this->setElement(
            Element::line(
                Element::REQUEST,
                $element
            ),
            $value
        );
    }

    public function setElementInOrder($element, $value): self
    {
        return $this->setElementInRequest(Element::line(
            Element::ORDER,
            $element
        ), $value);
    }

    public function getElements(): array
    {
        $elements = [];
        foreach ($this->elements as $element => $value) {
            Arr::set($elements, $element, $value);
        }
        return $elements;
    }

    public function toArray(): array
    {
        return [
            Element::ROOT => $this->getElements()
        ];
    }
}
