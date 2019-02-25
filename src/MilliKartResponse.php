<?php

namespace Chameleon;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class MilliKartResponse implements Arrayable, Jsonable, \ArrayAccess
{

    /**
     * @var array
     */
    const CODE = [
        'UNKNOWN'     => -1, //Or Not Found
        'OK'          => 0,
        'FAILED'      => 1,
        'CREATED'     => 2,
        'PENDING'     => 3,
        'DECLINED'    => 4,
        'REVERSED'    => 5,
        'TIMEOUT'     => 7,
        'CANCELLED'   => 9,
        'RETURNED'    => 10,
        'ACTIVE'      => 11,
        'ATTEMPT'     => 12,
        'PENDING_3DS' => 13
    ];
    /**
     * @var array;
     */
    private $data = [];

    /**
     * MilliKartResponse constructor.
     * @param string|array $body
     */
    public function __construct($body)
    {
        $this->setData($body);
    }

    /**
     * @return string
     */
    public function redirect()
    {
        return $this->get('redirect');
    }

    /**
     * @return int
     */
    public function code()
    {
        return (int)$this->get('code', self::CODE['UNKNOWN']);
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->get('description');
    }

    /**
     * @return float
     */
    public function amount()
    {
        return (float)($this->amountInt() / 100);
    }

    /**
     * @return int
     */
    public function amountInt()
    {
        return (int)$this->get('amount');
    }

    /**
     * ISO 4217 code
     * @return int
     */
    public function currency()
    {
        return (int)$this->get('currency');
    }

    /**
     * @return string
     */
    public function paymentDescription()
    {
        return $this->get('payment-description');
    }

    /**
     * @return string
     */
    public function reference()
    {
        return $this->get('reference');
    }

    /**
     * @return int|null
     */
    public function timestamp()
    {
        return ($time = $this->time()) ? $time->timestamp : null;
    }

    /**
     * @return Carbon|null
     */
    public function time()
    {
        return $this->get('timestamp')
            ? Carbon::createFromFormat('Y m d H i s', $this->get('timestamp'))
            : null;
    }

    /**
     * @return string
     */
    public function xid()
    {
        return $this->get('xid');
    }

    /**
     * @return int
     */
    public function rrn()
    {
        return $this->get('rrn');
    }

    /**
     * @return int
     */
    public function approval()
    {
        return $this->get('approval');
    }

    /**
     * @return array|mixed
     */
    public function pan()
    {
        return $this->get('pan');
    }

    /**
     * @return null|string
     */
    public function cardLast4()
    {
        return $this->pan() ? substr($this->pan(), -4) : null;
    }


    /**
     * @return string
     */
    public function responseCode()
    {
        return $this->rc();
    }

    /**
     * @return string
     */
    public function rc()
    {
        return $this->get('RC');
    }

    /**
     * @return int
     */
    public function reimbursement()
    {
        return $this->get('reimbursment', $this->get('reimbursement', null));
    }


    /**
     * Return true if valid register response
     * @return bool
     */
    public function isValidRegister()
    {
        return $this->redirect() !== null;
    }

    /**
     * Return true if valid status response
     * @return bool
     */
    public function isValidStatus()
    {
        return $this->reference() !== null;
    }

    /**
     * @return bool
     */
    public function isValidResponse()
    {
        return $this->code() !== self::CODE['UNKNOWN'];
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->code() === self::CODE['OK'];
    }

    /**
     * @param string     $key
     * @param null|mixed $default
     * @return array|mixed
     */
    public function get($key = null, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|string $data
     */
    public function setData($data)
    {
        $this->data = is_string($data)
            ? $this->xmlToArray($data)
            : (array)$data;
    }

    /**
     * @param string $xml
     * @return array
     */
    protected function xmlToArray($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml)), true);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->data, $options);
    }

    /**
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->data[$offset] = null;
        unset($this->data[$offset]);
    }
}
