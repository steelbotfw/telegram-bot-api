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
