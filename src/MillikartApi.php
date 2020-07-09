<?php

namespace Chameleon\Millikart;

use Chameleon\Millikart\Formatter\ApiFormatter;
use Chameleon\Millikart\Formatter\JsonFormatter;
use Chameleon\Millikart\Formatter\XmlFormatter;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class MillikartApi
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $gateway;
    /**
     * @var ApiFormatter
     */
    private $formatter;

    private $options = [];

    public function __construct(Client $client, $gateway)
    {
        $gateway = rtrim($gateway, '/');
        $this->client = $client;
        $this->gateway = $gateway;
        $this->formatter = $this->makeFormatter($gateway);
    }

    private function makeFormatter($gateway)
    {
        if (Str::endsWith($gateway, JsonFormatter::EXECUTION_PATH)
            || parse_url($gateway, PHP_URL_PATH) === null) {
            return new JsonFormatter();
        }
        if (Str::endsWith($gateway, XmlFormatter::EXECUTION_PATH)) {
            return new XmlFormatter();
        }
    }

    public function setFormatter(ApiFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function request($elements)
    {
        $response = $this->client
            ->post($this->gateway, array_merge($this->options, $this->formatter->toRequestOptions($elements)));

        return new Response($this->formatter->toResponseElements($response));
    }

}