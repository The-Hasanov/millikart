<?php

namespace Chameleon\Millikart\Formatter;

use Psr\Http\Message\MessageInterface;

class JsonFormatter implements ApiFormatter
{
    public const EXECUTION_PATH = '/execjson';

    public function toRequestOptions(array $data)
    {
        return [
            'headers' => [
                'Content-type' => 'text/json'
            ],
            'body'    => json_encode($data)
        ];
    }

    public function toResponseElements(MessageInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}