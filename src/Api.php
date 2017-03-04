<?php

namespace Steelbot\TelegramBotApi;

use Icicle\Http\{
    Client\Client,
    Message\Response
};
use Icicle\Http\Message\BasicUri;
use Icicle\Stream\MemoryStream;
use Icicle\Stream\ReadableStream;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetUpdates;
use Steelbot\TelegramBotApi\Type;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;

/**
 * Telegram bot API
 *
 * @see https://core.telegram.org/bots/api#available-methods
 */
class Api
{
    /**
     * @var string
     */
    protected $baseUrl = 'https://api.telegram.org/bot';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \Icicle\Http\Client\Client
     */
    protected $httpClient;

    /**
     * @var int
     */
    protected $lastUpdateId = 1;

    /**
     * @param string $token
     */
    public function __construct(string $token, Client $httpClient = null)
    {
        if (!$token) {
            throw new \UnexpectedValueException("Telegram token must be set.");
        }
        $this->token = $token;

        if ($httpClient === null) {
            $httpClient = new Client();
        }
        $this->httpClient = $httpClient;
    }

    /**
     * @return \Icicle\Http\Client\Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * Execute an API method.
     *
     * @param AbstractMethod $method
     *
     * @return \Generator
     * @throws TelegramBotApiException
     * @resolve object
     */
    public function execute(AbstractMethod $method): \Generator
    {
        switch ($method->getHttpMethod()) {
            case $method::HTTP_GET:
                $response = yield from $this->get('/'.$method->getMethodName(), $method->getParams());
                break;
            case $method::HTTP_POST:
                if ($method instanceof \JsonSerializable) {
                    $body = json_encode($method);

                    $bodyStream = new MemoryStream(0, $body);
                    yield from $bodyStream->end();
                    $contentLength = mb_strlen($body);
                } else {
                    $bodyStream = null;
                    $contentLength = 0;
                }

                $headers = [
                    'Content-Type' => 'application/json',
                    'Content-Length' => $contentLength
                ];
                $response = yield from $this->post('/'.$method->getMethodName(), $method->getParams(), $headers, $bodyStream);
                break;
        }

        $body = yield from $this->getResponseBody($response);
        $body = json_decode($body, true);

        if ($body['ok'] === false) {
            $exception = new TelegramBotApiException($body['description'], $body['error_code']);

            if (isset($body['parameters'])) {
                $parameters = new Type\ResponseParameters($body['parameters']);
                $exception->setParameters($parameters);
            }

            throw $exception;
        }

        return $method->buildResult($body['result']);
    }

    /**
     * @param int $lastUpdateId
     * @param int $limit
     * @param int $timeout
     *
     * @return \Generator
     * @resolve Update[]
     */
    public function getUpdates($lastUpdateId = null, int $limit = 5, int $timeout = 30) : \Generator
    {
        if ($lastUpdateId !== null) {
            $this->lastUpdateId = $lastUpdateId;
        }

        $method = new GetUpdates($this->lastUpdateId + 1, $limit, $timeout);

        $updates = yield from $this->execute($method);
        $this->lastUpdateId = $method->getLastUpdateId();

        return $updates;
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return \Generator
     */
    protected function get(string $pathName, array $params = [], $headers = []): \Generator
    {
        $url = $this->buildUrl($pathName, $params);

        return $this->httpClient->request('GET', $url, $headers, null, [
            'timeout' => 60
        ]);
    }

    /**
     * @param string $pathName
     * @param array $params
     *
     * @yield Generator
     */
    protected function post(string $pathName, array $params = [], $headers = [], ReadableStream $body = null): \Generator
    {
        $url = $this->buildUrl($pathName, $params);

        return $this->httpClient->request('POST', $url, $headers, $body, [
            'timeout' => 60
        ]);
    }

    /**
     * Build full URL to a telegram API with given pathName
     *
     * @param string $pathName
     *
     * @return string
     */
    protected function buildUrl(string $pathName, array $params = []): string
    {
        $uri = new BasicUri($this->baseUrl.$this->token.$pathName);
        foreach ($params as $name => $value) {
            if (is_bool($value)) {
                $value = (int)$value;
            }
            $uri = $uri->withQueryValue($name, $value);
        }

        return (string) $uri;
    }

    /**
     * @param Response $response
     *
     * @return \Generator
     *
     * @resolve string
     */
    protected function getResponseBody(Response $response): \Generator
    {
        $data = '';
        $stream = $response->getBody();
        while ($stream->isReadable()) {
            $data .= yield $stream->read();
        }

        return $data;
    }
}
