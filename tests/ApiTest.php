<?php

namespace Steelbot\Tests\TelegramBotApi;

use Icicle\Coroutine\Coroutine;
use Icicle\Http\Client\Client;
use Icicle\Http\Message\Response;
use Steelbot\TelegramBotApi\Api;
use Steelbot\Tests\TelegramBotApi\Stub\ReadableStreamStub;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    protected $httpClient;

    protected $telegramToken = '12345:telegram-token';

    public function setUp()
    {
        $this->httpClient = $this->getMock(Client::class);
    }

    public function testCreateWithEmptyClient()
    {
        $api = new Api($this->telegramToken);

        $this->assertInstanceOf(Client::class, $api->getHttpClient());
    }

    /**
     * @dataProvider getMeDataProvider
     */
    public function testGetMeSuccess(array $data, string $responseData)
    {
        $this->setUpHttpClient($responseData);

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->getMe());
        $user = $coroutine->wait();

        $this->assertInstanceOf(\Steelbot\TelegramBotApi\Type\User::class, $user);
        $this->assertEquals($data['result']['id'], $user->id);
        $this->assertEquals($data['result']['first_name'], $user->firstName);
        $this->assertEquals($data['result']['username'], $user->username);
    }

    public function getMeDataProvider()
    {
        $data = [
            'ok' => true,
            'result' => [
                'id'         => 987654321,
                'first_name' => 'Steel Bot',
                'username'   => 'SteelbotBot'
            ]
        ];

        return [
            [$data, json_encode($data)]
        ];
    }

    /**
     * @dataProvider sendMessageDataProvider
     */
    public function testSendMessageSuccess(array $data, string $responseData)
    {
        $this->setUpHttpClient($responseData);

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->sendMessage($data['result']['chat']['id'], $data['result']['text']));
        $message = $coroutine->wait();

        $this->assertInstanceOf(\Steelbot\TelegramBotApi\Type\Message::class, $message);
        $this->assertEquals($data['result']['message_id'], $message->messageId);
        $this->assertEquals($data['result']['from']['id'], $message->from->id);
        $this->assertEquals($data['result']['chat']['id'], $message->chat->id);
        $this->assertEquals($data['result']['text'], $message->text);
    }

    public function sendMessageDataProvider()
    {
        $data = [
            'ok' => true,
            'result' => [
                'message_id' => 4757,
                'from' => [
                    'id' => 987654320,
                    'first_name' => 'Steel Bot',
                    'username' => 'SteelbotBot'
                ],

                'chat' => [
                    'id' => 987654321,
                    'first_name' => 'Mister',
                    'last_name' => 'Botman',
                    'username' => 'mrbotman',
                    'type' => 'private'
                ],

                'date' => 1456600086,
                'text' => 'Hello there!'
            ]
        ];

        $data2 = [
            'ok' => true,
            'result' => [
                'message_id' => 4757,
                'from' => [
                    'id' => 987654320,
                    'username' => 'SteelbotBot'
                ],

                'chat' => [
                    'id' => 987654321,
                    'type' => 'private'
                ],

                'date' => 1456600086,
                'text' => 'Hello there!'
            ]
        ];

        return [
            [$data,  json_encode($data)],
            [$data2, json_encode($data2)]
        ];
    }

    public function testSendMessageUnauthorized()
    {
        $data = [
            'ok' => false,
            'error_code' => 401,
            'description' => '[Error]: Unauthorized'
        ];

        $this->setUpHttpClient(json_encode($data));

        $api = new Api($this->telegramToken.'_invalid', $this->httpClient);

        try {
            $coroutine = new Coroutine($api->sendMessage(123, "Hello"));

            $coroutine->wait();
            $this->fail("Expected exception TelegramBotApiException not thrown");
        } catch (TelegramBotApiException $e) {
            $this->assertEquals($data['error_code'], $e->getCode());
            $this->assertEquals($data['description'], $e->getMessage());
        }
    }

    /**
     * @param string $responseData
     */
    protected function setUpHttpClient(string $responseData)
    {
        $response = $this->getMock(Response::class);
        $response->method('getBody')
            ->willReturn(new ReadableStreamStub($responseData));

        $this->httpClient->expects($this->once())
            ->method('request')
            ->will($this->returnCallback(function() use ($response) {
                return yield $response;
            }));
    }
}
