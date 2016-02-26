<?php

namespace Steelbot\TelegramBotApi;

use Icicle\Http\{
    Client\Client,
    Message\Response
};
use Icicle\Http\Message\BasicUri;
use Steelbot\TelegramBotApi\Entity;

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
     * @param string $token
     */
    public function __construct(string $token, Client $httpClient)
    {
        $this->token = $token;
        $this->httpClient = $httpClient;
    }

    /**
     * @see https://core.telegram.org/bots/api#getme
     *
     * @coroutine
     *
     * @return \Generator
     * @resolve Entity\User
     */
    public function getMe() : \Generator
    {
        /** @var Response $response */
        $response = yield from $this->get('/getMe');

        $body = yield from $this->getResponseBody($response);
        $body = json_decode($body, true);

        return new Entity\User($body['result']);
    }

    /**
     * @param string $url
     * @param array $params
     *
     * @return \Generator
     */
    protected function get(string $pathName, array $params = []): \Generator
    {
        $url = $this->buildUrl($pathName, $params);

        return $this->request('GET', $url, [], null, [
            'timeout' => 60
        ]);
    }

    /**
     * @param string $method
     * @param        $uri
     * @param array  $headers
     * @param null   $body
     * @param array  $options
     *
     *
     * @return \Generator
     */
    protected function request(string $method, $uri, array $headers = [], $body = null, array $options = []): \Generator
    {
        return $this->httpClient->request($method, $uri, $headers, $body, $options);
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
