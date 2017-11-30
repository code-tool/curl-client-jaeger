<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\StringTag;

class HttpUserAgentTag extends StringTag
{
    public function __construct(string $value)
    {
        parent::__construct('http.agent', $value);
    }
}
