<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\StringTag;

class HttpUserAgentTag extends StringTag
{
    /**
     * HttpUserAgentTag constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct('http.agent', (string)$value);
    }
}
