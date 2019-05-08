<?php

namespace Chameleon;

use Illuminate\Contracts\Support\Arrayable;

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
    protected static $params = [
        'mid',
        'amount',
        'currency',
        'description',
        'reference',
        'language',
        'signature',
        'redirect'
    ];
    /**
     * @var array
     */
    protected static $signature_params = [
        'mid',
        'amount',
        'currency',
        'description',
        'reference',
        'language'
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
     * @param array|callable|MilliKartBuilder $params
     * @return MilliKartResponse
     */
    public function register($params)
    {
        $params = $this->mergeConfig($params);

        //generate after all params set
        $params['signature'] = $this->signature($params);

        return new MilliKartResponse(
            $this->request('register', $params),
            empty($params['redirect'])
                ? MilliKartResponse::TYPE['REGISTER']
                : MilliKartResponse::TYPE['REDIRECT']
        );
    }

    /**
     * @param string $reference
     * @return MilliKartResponse
     */
    public function status($reference)
    {
        $params = $this->mergeConfig(['reference' => $reference]);

        return new MilliKartResponse($this->request('status', $params), MilliKartResponse::TYPE['STATUS']);
    }

    /**
     * @param array $params
     * @return string
     */
    public function signature($params)
    {
        $str = '';
        foreach ($this->onlySignatureParams($params) as $key => $value) {
            if (!empty($value)) {
                $str .= strlen($value) . $value;
            }
        }

        return strtoupper(md5($str . $this->config['key']));
    }


    /**
     * @param string $path
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
        return array_merge(array_intersect_key(array_flip(self::$params), $params), $params);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function onlySignatureParams($params)
    {
        return $this->sortParams(array_intersect_key($params, array_flip(self::$signature_params)));
    }

    /**
     * @param $params
     * @return array
     */
    protected function mergeConfig($params)
    {
        if (is_callable($params)) {
            $params($params = new MilliKartBuilder());
        }

        return array_merge(
            array_intersect_key($this->config, array_flip(self::$params)),
            $params instanceof Arrayable ? $params->toArray() : $params
        );
    }

    /**
     * @param  string $path
     * @param array   $params
     * @return string
     */
    protected function request($path, $params = [])
    {
        return $this->content($this->buildUrl($path, $this->sortParams($params)));
    }

    /**
     * @param string $path
     * @param array  $params
     * @return string
     */
    private function buildUrl($path, $params = [])
    {
        return $this->gateway($path) . '?' . http_build_query($params);
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
}
