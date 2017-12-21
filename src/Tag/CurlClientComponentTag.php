<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\ComponentTag;

class CurlClientComponentTag extends ComponentTag
{
    public function __construct()
    {
        parent::__construct('curl.client');
    }
}
