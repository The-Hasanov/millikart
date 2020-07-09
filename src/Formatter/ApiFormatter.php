<?php

namespace Chameleon\Millikart\Formatter;

use Psr\Http\Message\MessageInterface;

interface ApiFormatter
{
    public function toRequestOptions(array $data);

    public function toResponseElements(MessageInterface $response);

}