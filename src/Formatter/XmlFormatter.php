<?php

namespace Chameleon\Millikart\Formatter;

use Chameleon\Millikart\Element;
use Psr\Http\Message\MessageInterface;
use Spatie\ArrayToXml\ArrayToXml;

class XmlFormatter implements ApiFormatter
{
    public const EXECUTION_PATH = '/exec';

    public function toRequestOptions(array $data)
    {
        return [
            'headers' => [
                'Content-type' => 'text/xml'
            ],
            'body'    => ArrayToXml::convert($data[Element::ROOT] ?? $data, Element::ROOT)
        ];
    }

    public function toResponseElements(MessageInterface $response)
    {
        return [
            Element::ROOT => json_decode(json_encode(
                simplexml_load_string($response->getBody()->getContents())
            ), true)
        ];
    }
}