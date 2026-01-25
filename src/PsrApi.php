<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
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
class PsrApi implements TelegramBotApiInterface
{
    private const string BASE_URL = 'https://api.telegram.org/bot';

    private int $lastUpdateId = 0;

    public function __construct(
        private readonly string $token,
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly string $baseUrl = self::BASE_URL,
    ) {
        if (empty($token)) {
            throw new UnexpectedValueException("Telegram token must be set.");
        }
    }

    /**
     * Execute an API method.
     *
     * @template T
     * @param AbstractMethod<T> $method
     *
     * @return T
     *
     * @throws TelegramBotApiException
     */
    public function execute(AbstractMethod $method): object|array|bool|int
    {
        switch ($method->getHttpMethod()) {
            case HttpMethod::GET:
                $request = $this->requestFactory->createRequest(
                    $method->getHttpMethod()->value,
                    $this->buildUrl($method)
                );
                break;

            case HttpMethod::POST:
                if (!$method instanceof \JsonSerializable) {
                    throw new UnexpectedValueException("Method must implement JsonSerializable interface.");
                }

                $body = json_encode($method, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

                $request = $this->requestFactory->createRequest(
                    $method->getHttpMethod()->value,
                    $this->buildUrl($method)
                );
                $request = $request
                    ->withHeader('Content-Type', 'application/json')
                    ->withBody($this->streamFactory->createStream($body));
                break;

            default:
                throw new UnexpectedValueException("Unsupported HTTP method {$method->getHttpMethod()->value}");
        }

        $response = $this->httpClient->sendRequest($request);
        $body = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

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
        if (!empty($method->getParams())) {
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
}
