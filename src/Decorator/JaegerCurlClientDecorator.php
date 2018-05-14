<?php

namespace Http\Client\Curl\Jaeger\Decorator;

use Http\Client\Curl\CurlClientInterface;
use Http\Client\Curl\Decorator\AbstractCurlClientDecorator;
use Http\Client\Curl\Jaeger\Log\HttpConnectTimeLog;
use Http\Client\Curl\Jaeger\Log\HttpResolveTimeLog;
use Http\Client\Curl\Jaeger\Log\HttpResponseFinishTimeLog;
use Http\Client\Curl\Jaeger\Log\HttpResponseStartTimeLog;
use Http\Client\Curl\Jaeger\Tag\CurlClientComponentTag;
use Http\Client\Curl\Request\CurlRequest;
use Http\Client\Curl\Response\CurlResponse;
use Http\Client\Exception\RequestException;
use Jaeger\Codec\CodecInterface;
use Jaeger\Codec\CodecRegistry;
use Jaeger\Http\HttpCodeTag;
use Jaeger\Http\HttpMethodTag;
use Jaeger\Http\HttpUriTag;
use Jaeger\Log\ErrorLog;
use Jaeger\Log\UserLog;
use Jaeger\Tag\ErrorTag;
use Jaeger\Tag\PeerAddressTag;
use Jaeger\Tag\PeerHostnameTag;
use Jaeger\Tag\PeerIpv4Tag;
use Jaeger\Tag\PeerPortTag;
use Jaeger\Tag\SpanKindClientTag;
use Jaeger\Tracer\TracerInterface;
use Psr\Log\LogLevel;

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
     * @param string              $header
     * @param string              $format
     * @param CodecRegistry       $registry
     * @param TracerInterface     $tracer
     * @param CurlClientInterface $curlClient
     */
    public function __construct(
        $header,
        $format,
        CodecRegistry $registry,
        TracerInterface $tracer,
        CurlClientInterface $curlClient
    ) {
        $this->header = (string)$header;
        $this->format = (string)$format;
        $this->registry = $registry;
        $this->tracer = $tracer;
        parent::__construct($curlClient);
    }

    /**
     * @param CurlRequest $request
     *
     * @return CurlResponse
     */
    public function send(CurlRequest $request)
    {
        $span = $this->tracer->start(
            'http.request',
            [
                new HttpMethodTag($request->getMethod()),
                new HttpUriTag($request->getUri()->__toString()),
                new SpanKindClientTag(),
                new CurlClientComponentTag(),
                new PeerAddressTag(sprintf('%s:%s', $request->getUri()->getHost(), $request->getUri()->getPort())),
                new PeerHostnameTag($request->getUri()->getHost())
            ]
        );
        $span->addLog(
            new UserLog(
                'jaeger.header',
                LogLevel::DEBUG,
                sprintf('%s: %s', $this->header, $this->registry[$this->format]->encode($span->getContext()))
            )
        );
        $response = null;
        try {
            $time = microtime(true);
            $response = parent::send(
                $request->withHeader($this->header, $this->registry[$this->format]->encode($span->getContext()))
            );
            $curlInfo = $response->curlInfo();
            $span
                ->addTag(new HttpCodeTag($response->getStatusCode()))
                ->addTag(new PeerIpv4Tag($curlInfo->primaryIp()))
                ->addTag(new PeerPortTag($curlInfo->primaryPort()))
                ->addLog(new HttpConnectTimeLog($time, $curlInfo->connectTime()))
                ->addLog(new HttpResolveTimeLog($time, $curlInfo->namelookupTime()))
                ->addLog(new HttpResponseStartTimeLog($time, $curlInfo->starttransferTime()))
                ->addLog(new HttpResponseFinishTimeLog($time, $curlInfo->totalTime()));
        } catch (RequestException $e) {
            $span->addTag(new ErrorTag());
            $span->addLog(new ErrorLog($e->getMessage(), $e->getTraceAsString()));

            throw $e;
        } finally {
            $this->tracer->finish($span);
        }

        return $response;
    }
}
