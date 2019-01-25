<?php

namespace Chameleon;

/**
 * Class MilliKart
 * @package Chameleon
 */
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
        0  => 'OK',
        1  => 'Failed',
        2  => 'Created',
        3  => 'Pending',
        4  => 'Declined',
        5  => 'Reversed',
        7  => 'Timeout',
        9  => 'Cancelled',
        10 => 'Returned',
        11 => 'Active',
        12 => 'Attempt',
        13 => 'Pending3DS',

    ];
    /**
     * @var array
     */
    private $request_options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                'User-Agent: PHP'
            ]
        ]
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
        $params = $this->mergeConfig($params);

        //generate after all params set
        $params['signature'] = $this->signature($params);

        return $this->request('register', $params);
    }

    /**
     * @param string $reference
     * @return array
     */
    public function status($reference)
    {
        $params = $this->mergeConfig(['reference' => $reference]);

        return $this->request('status', $params);
    }

    /**
     * @param array $params
     * @return string
     */
    public function signature($params)
    {
        $str = '';
        foreach ($this->sortParams($params) as $key => $value) {
            if (!empty($value)) {
                $str .= strlen($value) . $value;
            }
        }

        return strtoupper(md5($str . $this->config['key']));
    }


    /**
     * @return string
     */
    public function gateway($path = '')
    {
        return $this->config[$this->config['env'] . '_gateway'] . ($path ? '/' . $path : '');
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
     * @param $params
     * @return array
     */
    protected function mergeConfig($params)
    {
        return array_merge(array_intersect_key($this->config, array_flip($this->params)), $params);
    }

    /**
     * @param  string $path
     * @param array   $params
     * @return array
     */
    protected function request($path, $params = [])
    {
        return $this->xmlToArray(
            $this->content($this->gateway($path) . '?' . http_build_query($this->sortParams($params)))
        );
    }


    /**
     * @param string $url
     * @return bool|string
     */
    private function content($url)
    {
        return file_get_contents($url, false, stream_context_create($this->request_options));
    }

    /**
     * @param array $request_options
     */
    public function setRequestOptions(array $request_options)
    {
        $this->request_options = $request_options;
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
