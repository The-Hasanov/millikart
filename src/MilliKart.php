<?php
namespace Chameleon;

class MilliKart
{
    /**
     * @var array
     */
    protected $config = [];
    /**
     * @var array
     */
    protected $params = [
        'mid',
        'amount',
        'currency',
        'description',
        'reference',
        'language',
        'signature'
    ];

    /**
     * @var array
     */
    public static $code = [
        -1 => 'Unknown',
        0 => 'OK',
        1 => 'Failed',
        2 => 'Created',
        3 => 'Pending',
        4 => 'Declined',
        5 => 'Reversed',
        7 => 'Timeout',
        9 => 'Cancelled',
        10 => 'Returned',
        11 => 'Active',
        12 => 'Attempt',
        13 => 'Pending3DS',

    ];

    /**
     * MilliKart constructor.
     * @param  array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param array $params
     * @return array
     */
    public function register($params)
    {
        $params['mid'] = $this->config['mid'];
        $params['currency'] = array_key_exists('currency', $params) ? $params['currency'] : $this->config['currency'];
        $params['language'] = array_key_exists('language', $params) ? $params['language'] : $this->config['language'];

        //generate after all params set
        $params['signature'] = $this->signature($params);

        $xml = file_get_contents($this->gateway() . '/register?' . http_build_query($this->sortParams($params)));

        return $this->xmlToArray($xml);
    }

    /**
     * @param string $reference
     * @return array
     */
    public function status($reference)
    {
        $params['mid'] = $this->config['mid'];
        $params['reference'] = $reference;

        $xml = file_get_contents($this->gateway() . '/status?' . http_build_query($this->sortParams($params)));

        return $this->xmlToArray($xml);
    }

    /**
     * @param array $params
     * @return string
     */
    public function signature($params)
    {
        $str = '';
        foreach ($this->sortParams($params) as $key => $value) {
            if (!empty($value))
                $str .= strlen($value) . $value;
        }

        return strtoupper(md5($str . $this->config['key']));
    }


    /**
     * @return string
     */
    public function gateway()
    {
        return $this->config[$this->config['env'] . '_gateway'];
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function sortParams($params)
    {
        return array_merge(array_intersect_key(array_flip($this->params), $params), $params);
    }

    /**
     * @param string $xml
     * @return array
     */
    protected function xmlToArray($xml)
    {

        return json_decode(json_encode(simplexml_load_string($xml)), true);
    }

}