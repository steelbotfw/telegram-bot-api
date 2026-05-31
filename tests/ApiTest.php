<?php

namespace Steelbot\Tests\TelegramBotApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\Tests\TelegramBotApi\Stub\AbstractMethodWithBodyStub;

class ApiTest extends TestCase
{
    protected string $telegramToken = '12345:telegram-token';

    public function testCreateWithEmptyClient(): void
    {
        $api = new Api($this->telegramToken);

        $this->assertInstanceOf(Client::class, $api->getHttpClient());
    }

    public function testExecuteOk(): void
    {
        $method = $this->createMock(AbstractMethod::class);
        $method->expects($this->once())->method('getMethodName')->willReturn('someMethod');
        $method->expects($this->once())->method('getHttpMethod')->willReturn('GET');
        $method->expects($this->once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2',
        ]);
        $method->expects($this->once())->method('buildResult')->willReturn('result');

        $httpClient = $this->setUpHttpClient(json_encode([
            'ok' => true,
            'result' => 'result',
        ], JSON_UNESCAPED_UNICODE));

        $api = new Api($this->telegramToken, $httpClient);

        $result = $api->execute($method);

        $this->assertEquals('result', $result);
    }

    public function testExecuteNotOk(): void
    {
        $method = $this->createMock(AbstractMethod::class);
        $method->expects($this->once())->method('getMethodName')->willReturn('someMethod');
        $method->expects($this->once())->method('getHttpMethod')->willReturn('GET');
        $method->expects($this->once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2',
        ]);
        $method->expects($this->never())->method('buildResult')->willReturn('result');

        $httpClient = $this->setUpHttpClient(json_encode([
            'ok' => false,
            'description' => 'Error description',
            'error_code' => 42,
        ], JSON_UNESCAPED_UNICODE));

        $api = new Api($this->telegramToken, $httpClient);

        try {
            $api->execute($method);
            $this->fail("Expected exception TelegramBotApiException not thrown");
        } catch (TelegramBotApiException $exception) {
            $this->assertEquals('Error description', $exception->getMessage());
            $this->assertEquals(42, $exception->getCode());
        }
    }

    public function testExecuteWithJsonBody(): void
    {
        $method = $this->createMock(AbstractMethodWithBodyStub::class);
        $method->expects($this->once())->method('getMethodName')->willReturn('someMethod');
        $method->expects($this->once())->method('getHttpMethod')->willReturn('POST');
        $method->expects($this->once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2',
        ]);
        $method->expects($this->once())->method('buildResult')->willReturn('result');
        $method->expects($this->once())->method('jsonSerialize')->willReturn([
            'jsonParam1' => 'jsonValue1',
            'jsonParam2' => 'jsonValue2',
        ]);

        $httpClient = $this->setUpHttpClient(json_encode([
            'ok' => true,
            'result' => 'result',
        ], JSON_UNESCAPED_UNICODE));

        $api = new Api($this->telegramToken, $httpClient);

        $result = $api->execute($method);

        $this->assertEquals('result', $result);
    }

    protected function setUpHttpClient(string $responseData): ClientInterface
    {
        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->willReturn(new Response(200, [], $responseData));

        return $httpClient;
    }
}
