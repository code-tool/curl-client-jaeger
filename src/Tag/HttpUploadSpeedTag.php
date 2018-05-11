<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\DoubleTag;

class HttpUploadSpeedTag extends DoubleTag
{
    public function __construct(float $value)
    {
        parent::__construct('http.upload_speed', $value);
    }
}
