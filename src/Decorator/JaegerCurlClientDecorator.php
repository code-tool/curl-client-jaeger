<?php
declare(strict_types=1);

namespace Http\Client\Curl\Jaeger\Decorator;

use Http\Client\Curl\CurlClientInterface;
use Http\Client\Curl\Decorator\AbstractCurlClientDecorator;
use Http\Client\Curl\Jaeger\Log\HttpConnectTimeLog;
use Http\Client\Curl\Jaeger\Log\HttpResolveTimeLog;
use Http\Client\Curl\Jaeger\Log\HttpResponseFinishTimeLog;
use Http\Client\Curl\Jaeger\Log\HttpResponseStartTimeLog;
use Http\Client\Curl\Jaeger\Tag\CurlClientComponentTag;
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
use Psr\Http\Message\RequestInterface;
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

    public function __construct(
        string $header,
        string $format,
        CodecRegistry $registry,
        TracerInterface $tracer,
        CurlClientInterface $curlClient
    ) {
        $this->header = $header;
        $this->format = $format;
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
            $response = parent::sendRequest(
                $request->withHeader($this->header, $this->registry[$this->format]->encode($span->getContext()))
            );
            $curlInfo = $response->getCurlInfo();
            $span
                ->addTag(new HttpCodeTag($response->getStatusCode()))
                ->addTag(new PeerIpv4Tag($curlInfo[CurlClientInterface::CURL_PRIMARY_IP]))
                ->addTag(new PeerPortTag($curlInfo[CurlClientInterface::CURL_PRIMARY_PORT]))
                ->addLog(new HttpConnectTimeLog($time, $curlInfo[CurlClientInterface::CURL_CONNECT_TIME]))
                ->addLog(new HttpResolveTimeLog($time, $curlInfo[CurlClientInterface::CURL_NAMELOOKUP_TIME]))
                ->addLog(new HttpResponseStartTimeLog($time, $curlInfo[CurlClientInterface::CURL_STARTTRANSFER_TIME]))
                ->addLog(new HttpResponseFinishTimeLog($time, $curlInfo[CurlClientInterface::CURL_TOTAL_TIME]));
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
