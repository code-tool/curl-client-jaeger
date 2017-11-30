<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpConnectTimeTag extends DoubleTag
{
    public function __construct(float $value)
    {
        parent::__construct('http.connect_time', $value);
    }
}
