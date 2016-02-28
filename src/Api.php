<?php

namespace Steelbot\TelegramBotApi;

use Icicle\Http\{
    Client\Client,
    Message\Response
};
use Icicle\Http\Message\BasicUri;
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
     * @param string $token
     */
    public function __construct(string $token, Client $httpClient = null)
    {
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
     * @see https://core.telegram.org/bots/api#getme
     *
     * @coroutine
     *
     * @return \Generator
     * @resolve Type\User
     */
    public function getMe() : \Generator
    {
        /** @var Response $response */
        $response = yield from $this->get('/getMe');

        $body = yield from $this->getResponseBody($response);
        $body = json_decode($body, true);

        return new Type\User($body['result']);
    }

    /**
     * Send message to a user
     *
     * @see https://core.telegram.org/bots/api#sendmessage
     *
     * @coroutine
     *
     * @param int|string  $chatId
     * @param string      $text
     * @param bool        $disableWebPagePreview
     * @param bool        $disableNotification
     * @param int|null    $replyToMessageId
     * @param string|null $replyMarkup
     *
     * @return \Generator
     * @resolve Type\Message
     */
    public function sendMessage(       $chatId,
                                string $text,
                                string $parseMode = null,
                                bool   $disableWebPagePreview = false,
                                bool   $disableNotification = false,
                                int    $replyToMessageId = null,
                                string $replyMarkup = null): \Generator
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text
        ];

        if ($parseMode) {
            $params['parse_mode'] = $parseMode;
        }

        if ($disableWebPagePreview) {
            $params['disable_web_page_preview'] = $disableWebPagePreview;
        }
        if ($disableNotification) {
            $params['disable_notification'] = $disableNotification;
        }
        if ($replyToMessageId) {
            $params['reply_to_message_id'] = $replyToMessageId;
        }
        if ($replyMarkup) {
            $params['reply_markup'] = $replyMarkup;
        }

        $response = yield from $this->post('/sendMessage', $params);

        $body = yield from $this->getResponseBody($response);
        $body = json_decode($body, true);

        if ($body['ok'] === false) {
            throw new TelegramBotApiException($body['description'], $body['error_code']);
        }

        return new Type\Message($body['result']);
    }

    /**
     * Forward message to a user or chat
     *
     * @see     https://core.telegram.org/bots/api#forwardmessage
     *
     * @param int|string $chatId
     * @param int|string $fromChatId
     * @param bool       $disableNotification
     * @param int        $messageId
     *
     * @return \Generator
     * @throws TelegramBotApiException
     * @resolve Type\Message
     */
    public function forwardMessage(      $chatId,
                                         $fromChatId,
                                    bool $disableNotification = false,
                                    int  $messageId
                                  ): \Generator
    {
        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId
        ];

        if ($disableNotification) {
            $params['disable_notification'] = $disableNotification;
        }

        $response = yield from $this->post('/forwardMessage', $params);

        $body = yield from $this->getResponseBody($response);
        $body = json_decode($body, true);

        if ($body['ok'] === false) {
            throw new TelegramBotApiException($body['description'], $body['error_code']);
        }

        return new Type\Message($body['result']);
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
     * @param string $pathName
     * @param array $params
     *
     * @yield Generator
     */
    protected function post(string $pathName, array $params = []): \Generator
    {
        $url = $this->buildUrl($pathName, $params);

        return $this->request('POST', $url, [], null, [
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
