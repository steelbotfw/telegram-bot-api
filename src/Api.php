<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi;

use Amp\Http\Client\HttpClient;
use Amp\Http\Client\Request;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetUpdates;
use Steelbot\TelegramBotApi\Method\HttpMethod;
use Steelbot\TelegramBotApi\Type\Basic\Update;
use UnexpectedValueException;

/**
 * Telegram bot API
 *
 * @see https://core.telegram.org/bots/api#available-methods
 */
class Api
{
    private const string BASE_URL = 'https://api.telegram.org/bot';

    private int $lastUpdateId = 0;

    public function __construct(
        private readonly string $token,
        private readonly HttpClient $httpClient,
        private readonly string $baseUrl = self::BASE_URL,
    ) {
        if (empty($token)) {
            throw new UnexpectedValueException("Telegram token must be set.");
        }
    }

    /**
     * Execute an API method.
     *
     * @param AbstractMethod $method
     *
     * @throws TelegramBotApiException
     */
    public function execute(AbstractMethod $method): object|array|bool|int
    {
        $body = json_decode($this->executeRaw($method), true, 512, JSON_THROW_ON_ERROR);

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
     * Execute an API method and return raw response body without JSON parsing.
     */
    public function executeRaw(AbstractMethod $method): string
    {
        $response = $this->httpClient->request($this->buildRequest($method));

        return $response->getBody()->buffer();
    }

    /**
     * @return Update[]
     */
    public function getUpdates(?int $lastUpdateId = null, int $limit = 5, int $timeout = 30): array
    {
        if ($lastUpdateId !== null) {
            $this->lastUpdateId = $lastUpdateId;
        }

        $method = new GetUpdates($this->lastUpdateId + 1, $limit, $timeout);

        $updates = $this->execute($method);
        $this->lastUpdateId = $method->getLastUpdateId();

        return $updates;
    }

    private function buildUrl(AbstractMethod $method): string
    {
        if ($method->getParams() !== []) {
            $url = sprintf(
                '%s%s/%s?%s',
                $this->baseUrl,
                $this->token,
                $method->getMethodName(),
                http_build_query($method->getParams())
            );
        } else {
            $url = sprintf('%s%s/%s', $this->baseUrl, $this->token, $method->getMethodName());
        }

        return $url;
    }

    private function buildRequest(AbstractMethod $method): Request
    {
        switch ($method->getHttpMethod()) {
            case HttpMethod::GET:
                return new Request($this->buildUrl($method), $method->getHttpMethod()->value);

            case HttpMethod::POST:
                if (!$method instanceof \JsonSerializable) {
                    throw new UnexpectedValueException("Method must implement JsonSerializable interface.");
                }

                $body = json_encode($method, JSON_THROW_ON_ERROR);
                $request = new Request($this->buildUrl($method), $method->getHttpMethod()->value, $body);
                $request->setHeaders([
                    'Content-Type' => 'application/json',
                    'Content-Length' => (string) mb_strlen($body),
                ]);

                return $request;

            default:
                throw new UnexpectedValueException("Unsupported HTTP method {$method->getHttpMethod()->value}");
        }
    }
}
