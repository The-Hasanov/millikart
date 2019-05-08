<?php

namespace Chameleon;

use Illuminate\Contracts\Support\Arrayable;

class MilliKartBuilder implements Arrayable
{
    /**
     * Currency Constants
     */
    const CURRENCY = [
        'AZN' => 944,
        'USD' => 840
    ];
    /**
     * @var array
     */
    private $params = [];

    /**
     * 100.00 azn -> 10000
     * @param float|int $amount
     * @return MilliKartBuilder
     */
    public function amount($amount)
    {
        $this->params['amount'] = (int)($amount * 100);
        return $this;
    }

    /**
     * Set Currency AZN & amount
     * @param float $amount
     * @return MilliKartBuilder
     */
    public function amountAZN($amount)
    {
        $this->currencyAZN();
        return $this->amount($amount);
    }

    /**
     * @param string $code
     * @return MilliKartBuilder
     */
    public function currency($code)
    {
        $this->params['currency'] = $code;
        return $this;
    }

    /**
     * @return MilliKartBuilder
     */
    public function currencyAZN()
    {
        return $this->currency(self::CURRENCY['AZN']);
    }

    /**
     * @return MilliKartBuilder
     */
    public function currencyUSD()
    {
        return $this->currency(self::CURRENCY['USD']);
    }

    /**
     * @param string $value
     * @return MilliKartBuilder
     */
    public function reference($value)
    {
        $this->params['reference'] = (string)$value;
        return $this;
    }

    /**
     * @param string $value
     * @return MilliKartBuilder
     */
    public function description($value)
    {
        $this->params['description'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return MilliKartBuilder
     */
    public function language($value)
    {
        $this->params['language'] = $value;
        return $this;
    }

    /**
     * @return MilliKartBuilder
     */
    public function languageAZ()
    {
        return $this->language('az');
    }

    /**
     * @return MilliKartBuilder
     */
    public function languageRU()
    {
        return $this->language('ru');
    }

    /**
     * @return MilliKartBuilder
     */
    public function enableRedirect()
    {
        $this->params['redirect'] = 1;
        return $this;
    }

    /**
     * @return MilliKartBuilder
     */
    public function disableRedirect()
    {
        $this->params['redirect'] = 0;
        return $this;
    }

    /**
     * @return MilliKartBuilder
     */
    public function languageEN()
    {
        return $this->language('en');
    }

    /**
     * @param string $param
     * @param string $value
     */
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
    }

    /**
     * Get the instance as an array.
     * @return array
     */
    public function toArray()
    {
        return $this->params;
    }
}
