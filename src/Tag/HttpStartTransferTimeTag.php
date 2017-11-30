<?php
namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpStartTransferTimeTag extends DoubleTag
{
    /**
     * HttpStartTransferTimeTag constructor.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        parent::__construct('http.start_transfer_time', (float)$value);
    }
}
