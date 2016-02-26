<?php

namespace Steelbot\Tests\TelegramBotApi;

use Icicle\Coroutine\Coroutine;
use Icicle\Http\Client\Client;
use Icicle\Http\Message\Response;
use Steelbot\TelegramBotApi\Api;
use Steelbot\Tests\TelegramBotApi\Stub\ReadableStreamStub;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    protected $httpClient;

    protected $telegramToken = '12345:telegram-token';

    public function setUp()
    {
        $this->httpClient = $this->getMock(Client::class);
    }

    public function testGetMeSuccess()
    {
        $data = [
            'ok' => true,
            'result' => [
                'id'         => 987654321,
                'first_name' => 'Steel Bot',
                'username'   => 'SteelbotBot'
            ]
        ];
        $responseData = json_encode($data);

        $response = $this->getMock(Response::class);
        $response->method('getBody')
            ->willReturn(new ReadableStreamStub($responseData));

        $this->httpClient->expects($this->once())
            ->method('request')
            ->will($this->returnCallback(function() use ($response) {
                return yield $response;
            }));

        $api = new Api($this->telegramToken, $this->httpClient);

        $coroutine = new Coroutine($api->getMe());
        $user = $coroutine->wait();

        $this->assertInstanceOf(\Steelbot\TelegramBotApi\Entity\User::class, $user);
        $this->assertEquals($data['result']['id'], $user->id);
        $this->assertEquals($data['result']['first_name'], $user->firstName);
        $this->assertEquals($data['result']['username'], $user->username);
    }
}
