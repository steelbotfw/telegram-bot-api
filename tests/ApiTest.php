<?php

namespace Steelbot\Tests\TelegramBotApi;

use Icicle\Coroutine\Coroutine;
use Icicle\Http\Client\Client;
use Icicle\Http\Message\Response;
use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\ForwardMessage;
use Steelbot\TelegramBotApi\Method\GetMe;
use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\Tests\TelegramBotApi\Stub\AbstractMethodWithBodyStub;
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

    public function testExecuteOk()
    {
        $method = $this->getMock(AbstractMethod::class);
        $method->expects($this->once())->method('getMethodName')->willReturn('/someMethod');
        $method->expects($this->once())->method('getHttpMethod')->willReturn('GET');
        $method->expects($this->once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2'
        ]);
        $method->expects($this->once())->method('buildResult')->willReturn('result');

        $responseData = json_encode([
            'ok' => true,
            'result' => 'result'
        ], JSON_UNESCAPED_UNICODE);
        $this->setUpHttpClient($responseData);

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->execute($method));
        $result = $coroutine->wait();

        $this->assertEquals('result', $result);
    }

    public function testExecuteNotOk()
    {
        $method = $this->getMock(AbstractMethod::class);
        $method->expects($this->once())->method('getMethodName')->willReturn('/someMethod');
        $method->expects($this->once())->method('getHttpMethod')->willReturn('GET');
        $method->expects($this->once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2'
        ]);
        $method->expects($this->never())->method('buildResult')->willReturn('result');

        $responseData = [
            'ok' => false,
            'description' => 'Error description',
            'error_code' => 42
        ];
        $this->setUpHttpClient(json_encode($responseData, JSON_UNESCAPED_UNICODE));

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->execute($method));
        try {
            $result = $coroutine->wait();
            $this->fail("Expected exception TelegramBotApiException not thrown");
        } catch (TelegramBotApiException $exception) {
            $this->assertEquals('Error description', $exception->getMessage());
            $this->assertEquals(42, $exception->getCode());
        }
    }

    public function testExecuteWithJsonBody()
    {
        $method = $this->getMock(AbstractMethodWithBodyStub::class);
        $method->expects($this->once())->method('getMethodName')->willReturn('/someMethod');
        $method->expects($this->once())->method('getHttpMethod')->willReturn('POST');
        $method->expects($this->once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2'
        ]);
        $method->expects($this->once())->method('buildResult')->willReturn('result');
        $method->expects($this->once())->method('jsonSerialize')->willReturn([
            'jsonParam1' => 'jsonValue1',
            'jsonParam2' => 'jsonValue2'
        ]);

        $responseData = json_encode([
            'ok' => true,
            'result' => 'result'
        ], JSON_UNESCAPED_UNICODE);
        $this->setUpHttpClient($responseData);

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->execute($method));
        $result = $coroutine->wait();

        $this->assertEquals('result', $result);
    }

    /**
     * @dataProvider getMeDataProvider
     */
    public function testGetMeSuccess(array $data, string $responseData)
    {
        $this->setUpHttpClient($responseData);

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->execute(new GetMe()));
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

        $method = new SendMessage($data['result']['chat']['id'], $data['result']['text']);
        $method->setDisableNotification(true)->setDisableWebPagePreview(true);
        $coroutine = new Coroutine($api->execute($method));
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

        $method = new SendMessage(123, "Hello");
        try {
            $coroutine = new Coroutine($api->execute($method));

            $coroutine->wait();
            $this->fail("Expected exception TelegramBotApiException not thrown");
        } catch (TelegramBotApiException $e) {
            $this->assertEquals($data['error_code'], $e->getCode());
            $this->assertEquals($data['description'], $e->getMessage());
        }
    }

    /**
     * @dataProvider forwardMessageDataProvider
     *
     * @param array  $data
     * @param string $responseData
     *
     * @throws TelegramBotApiException
     */
    public function testForwardMessageSuccess(array $data, string $responseData)
    {
        $this->setUpHttpClient($responseData);

        $api = new Api($this->telegramToken, $this->httpClient);

        $method = new ForwardMessage($data['result']['chat']['id'], $data['result']['chat'], $data['result']['message_id']);
        $coroutine = new Coroutine($api->execute($method));
        $message = $coroutine->wait();

        $this->assertInstanceOf(\Steelbot\TelegramBotApi\Type\Message::class, $message);
        $this->assertEquals($data['result']['message_id'], $message->messageId);
        $this->assertEquals($data['result']['from']['id'], $message->from->id);
        $this->assertEquals($data['result']['chat']['id'], $message->chat->id);
        $this->assertEquals($data['result']['text'], $message->text);
    }

    public function forwardMessageDataProvider()
    {
        $data = [
            'ok' => true,
            'result' => [
                'message_id' => 4567,
                'from' => [
                    'id' => 987654320
                ],
                'chat' => [
                    'id' => 12345678,
                    'type' => 'private'
                ],
                'text' => "Hello",
                'date' => time()
            ]
        ];

        return [
            [$data, json_encode($data)]
        ];
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
