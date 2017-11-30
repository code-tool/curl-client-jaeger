<?php
namespace Http\Client\Curl\Jaeger\Decorator;

use Http\Client\Curl\CurlClient;
use Http\Client\Curl\CurlClientInterface;
use Http\Client\Curl\Decorator\AbstractCurlClientDecorator;
use Http\Client\Curl\Jaeger\Tag\HttpConnectTimeTag;
use Http\Client\Curl\Jaeger\Tag\HttpDownloadSpeedTag;
use Http\Client\Curl\Jaeger\Tag\HttpLookupTimeTag;
use Http\Client\Curl\Jaeger\Tag\HttpPretransferTimeTag;
use Http\Client\Curl\Jaeger\Tag\HttpStartTransferTimeTag;
use Http\Client\Curl\Jaeger\Tag\HttpTotalTimeTag;
use Http\Client\Curl\Jaeger\Tag\HttpUploadSpeedTag;
use Jaeger\Codec\CodecInterface;
use Jaeger\Codec\CodecRegistry;
use Jaeger\Http\HttpCodeTag;
use Jaeger\Http\HttpMethodTag;
use Jaeger\Http\HttpUriTag;
use Jaeger\Tracer\TracerInterface;
use Psr\Http\Message\RequestInterface;

class JaegerCurlClientDecorator extends AbstractCurlClientDecorator
{
    private $header;

    private $format;

    /**
     * @var CodecInterface[]
     */
    private $registry;

    private $tracer;

    /**
     * JaegerCurlClientDecorator constructor.
     *
     * @param string          $header
     * @param string          $format
     * @param CodecRegistry   $registry
     * @param TracerInterface $tracer
     * @param CurlClient      $curlClient
     */
    public function __construct(
        $header,
        $format,
        CodecRegistry $registry,
        TracerInterface $tracer,
        CurlClient $curlClient
    ) {
        $this->header = (string)$header;
        $this->format = (string)$format;
        $this->registry = $registry;
        $this->tracer = $tracer;
        parent::__construct($curlClient);
    }

    public function sendRequest(RequestInterface $request)
    {
        $span = $this->tracer->start(
            'http.request',
            [
                new HttpMethodTag($request->getMethod()),
                new HttpUriTag($request->getUri()->__toString()),
            ]
        );
        $response = parent::sendRequest(
            $request->withHeader($this->header, $this->registry[$this->format]->encode($span->getContext()))
        );
        $curlInfo = $response->getCurlInfo();
        $span
            ->addTag(new HttpCodeTag($response->getStatusCode()))
            ->addTag(new HttpConnectTimeTag($curlInfo[CurlClientInterface::CURL_CONNECT_TIME]))
            ->addTag(new HttpLookupTimeTag($curlInfo[CurlClientInterface::CURL_NAMELOOKUP_TIME]))
            ->addTag(new HttpPretransferTimeTag($curlInfo[CurlClientInterface::CURL_PRETRANSFER_TIME]))
            ->addTag(new HttpStartTransferTimeTag($curlInfo[CurlClientInterface::CURL_STARTTRANSFER_TIME]))
            ->addTag(new HttpTotalTimeTag($curlInfo[CurlClientInterface::CURL_TOTAL_TIME]))
            ->addTag(new HttpDownloadSpeedTag($curlInfo[CurlClientInterface::CURL_SPEED_DOWNLOAD]))
            ->addTag(new HttpUploadSpeedTag($curlInfo[CurlClientInterface::CURL_SPEED_UPLOAD]));
        $this->tracer->finish($span);

        return $response;
    }
}