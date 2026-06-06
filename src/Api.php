<?php

namespace Steelbot\TelegramBotApi;

use Amp\Http\Client\HttpClient;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\Promise;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetUpdates;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;
use UnexpectedValueException;
use function Amp\call;
use JsonSerializable;

/**
 * Telegram bot API
 *
 * @see https://core.telegram.org/bots/api#available-methods
 */
class Api
{
    protected string $baseUrl = 'https://api.telegram.org/bot';

    protected string $token;

    protected HttpClient $httpClient;

    protected int $lastUpdateId = 1;

    /**
     * @param string $token
     */
    public function __construct(string $token, ?HttpClient $httpClient = null)
    {
        if (!$token) {
            throw new UnexpectedValueException("Telegram token must be set.");
        }
        $this->token = $token;
        $this->httpClient = $httpClient ?? HttpClientBuilder::buildDefault();
    }

    /**
     * Execute an API method.
     *
     * @param AbstractMethod $method
     *
     * @throws TelegramBotApiException
     */
    public function execute(AbstractMethod $method): Promise
    {
        return call(function () use ($method) {
            switch ($method->getHttpMethod()) {
                case $method::HTTP_GET:
                    $response = yield $this->get('/' . $method->getMethodName(), $method->getParams());
                    break;

                case $method::HTTP_POST:
                    if ($method instanceof JsonSerializable) {
                        $body = json_encode($method, JSON_THROW_ON_ERROR);
                        $contentLength = strlen($body);
                    } else {
                        $body = null;
                        $contentLength = 0;
                    }

                    $headers = [
                        'Content-Type' => 'application/json',
                        'Content-Length' => $contentLength
                    ];
                    $response = yield $this->post(
                        '/'.$method->getMethodName(), $method->getParams(), $headers, $body
                    );
                    break;

                default:
                    throw new \LogicException("Unsupported HTTP method: {$method->getHttpMethod()}");
            }

            $body = yield $response->getBody()->buffer();
            $body = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

            if ($body['ok'] === false) {
                $exception = new TelegramBotApiException($body['description'], $body['error_code']);

                if (isset($body['parameters'])) {
                    $parameters = new Type\ResponseParameters($body['parameters']);
                    $exception->setParameters($parameters);
                }

                throw $exception;
            }

            return $method->buildResult($body['result']);
        });
    }

    /**
     * @param int $lastUpdateId
     * @param int $limit
     * @param int $timeout
     */
    public function getUpdates($lastUpdateId = null, int $limit = 5, int $timeout = 30) : Promise
    {
        return call(function () use ($lastUpdateId, $limit, $timeout) {
            if ($lastUpdateId !== null) {
                $this->lastUpdateId = $lastUpdateId;
            }

            $method = new GetUpdates($this->lastUpdateId + 1, $limit, $timeout);

            $updates = yield $this->execute($method);
            $this->lastUpdateId = $method->getLastUpdateId();

            return $updates;
        });
    }

    /**
     * @param array<string, string|numeric> $params
     */
    protected function get(string $pathName, array $params = [], $headers = []): Promise
    {
        $url = $this->buildUrl($pathName, $params);
        $request = new Request($url);

        if (count($headers) > 0) {
            $request->setHeaders($headers);
        }

        return $this->httpClient->request($request);
    }

    /**
     * @param array<string, string|numeric> $params
     */
    protected function post(string $pathName, array $params = [], $headers = [], ?string $body = null): Promise
    {
        $url = $this->buildUrl($pathName, $params);
        $request = new Request($url, 'POST', $body);

        if (count($headers) > 0) {
            $request->setHeaders($headers);
        }

        return $this->httpClient->request($request);
    }

    /**
     * Build full URL to a telegram API with a given pathName
     *
     * @param array<string, string|numeric> $params
     */
    protected function buildUrl(string $pathName, array $params = []): string
    {
        $url = $pathName;

        if (count($params) > 0) {
            $url = $pathName . '?' . http_build_query($params);
        }

        return $this->baseUrl . $this->token . $url;
    }
}
