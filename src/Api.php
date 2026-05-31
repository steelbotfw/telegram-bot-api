<?php

namespace Steelbot\TelegramBotApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use JsonSerializable;
use Psr\Http\Message\ResponseInterface;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use UnexpectedValueException;

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
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @param string $token
     */
    public function __construct(string $token, ?ClientInterface $httpClient = null)
    {
        if (!$token) {
            throw new UnexpectedValueException("Telegram token must be set.");
        }
        $this->token = $token;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Execute an API method.
     *
     * @param AbstractMethod $method
     *
     * @throws TelegramBotApiException
     *
     * @return mixed
     */
    public function execute(AbstractMethod $method)
    {
        $options = [
            'query' => $method->getParams(),
            'timeout' => 60,
        ];

        if ($method instanceof JsonSerializable) {
            $options['json'] = $method->jsonSerialize();
        }

        $response = $this->httpClient->request(
            $method->getHttpMethod(),
            $this->buildUrl('/' . $method->getMethodName()),
            $options,
        );

        $body = $this->decodeResponseBody($response);

        if ($body['ok'] === false) {
            $descriptionValue = $body['description'] ?? null;
            $errorCodeValue = $body['error_code'] ?? null;
            $description = is_string($descriptionValue) ? $descriptionValue : 'Telegram API request failed.';
            $errorCode = is_int($errorCodeValue) ? $errorCodeValue : 0;
            $exception = new TelegramBotApiException($description, $errorCode);

            if (isset($body['parameters']) && is_array($body['parameters'])) {
                $parameters = new Type\ResponseParameters($body['parameters']);
                $exception->setParameters($parameters);
            }

            throw $exception;
        }

        return $method->buildResult($body['result'] ?? null);
    }

    /**
     * Build full URL to a telegram API with given pathName.
     *
     * @psalm-mutation-free
     */
    protected function buildUrl(string $pathName): string
    {
        return $this->baseUrl . $this->token . $pathName;
    }

    /**
     * @return array<string, mixed>&array{ok: bool}
     */
    private function decodeResponseBody(ResponseInterface $response): array
    {
        $body = json_decode((string) $response->getBody(), true);

        if (!is_array($body) || !isset($body['ok']) || !is_bool($body['ok'])) {
            throw new UnexpectedValueException('Telegram response must be a JSON object with a boolean "ok" field.');
        }

        return $body;
    }
}
