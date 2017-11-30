<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Tag;

use Jaeger\Tag\LongTag;

class HttpUploadSpeedTag extends LongTag
{
    public function __construct(int $value)
    {
        parent::__construct('http.upload_speed', $value);
    }
}
