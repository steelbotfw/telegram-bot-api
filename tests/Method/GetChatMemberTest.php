<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\AbstractMethod, Method\GetChatMember, Type\ChatMember
};
use PHPUnit\Framework\TestCase;

class GetChatMemberTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetMethodName()
    {
        $method = new GetChatMember(1, 42);

        $this->assertEquals('getChatMember', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetChatMember(1, 42);

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetChatMember(1, 42);

        $params = [
            'chat_id' => 1,
            'user_id' => 42
        ];
        $this->assertEquals($params, $method->getParams());
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($result)
    {
        $method = new GetChatMember(1, 42);

        $chatMember = $method->buildResult($result);

        $this->assertInstanceOf(ChatMember::class, $chatMember);
        $this->assertEquals($result['user']['id'], $chatMember->user->id);
        $this->assertEquals($result['status'], $chatMember->status);
    }

    public function buildResultDataProvider(): array
    {
        $chatMember = [
            'user' => [
                'id' => 42,
                'first_name' => 'FirstName',
                'last_name'  => 'LastName',
                'username'   => 'usrname'
            ],
            'status' => 'creator'
        ];

        return [
            [$chatMember]
        ];
    }
}
