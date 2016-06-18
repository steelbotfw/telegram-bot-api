<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\AbstractMethod, Method\GetChatAdministrators, Type\ChatMember
};

class GetChatAdministratorsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetChatAdministrators(1);

        $this->assertEquals('getChatAdministrators', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetChatAdministrators(1);

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetChatAdministrators(1);

        $params = [
            'chat_id' => 1
        ];
        $this->assertEquals($params, $method->getParams());
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($result)
    {
        $method = new GetChatAdministrators(1);

        $chatMembers = $method->buildResult($result);

        $this->assertCount(count($result), $chatMembers);
        foreach ($chatMembers as $i=>$chatMember) {
            $this->assertInstanceOf(ChatMember::class, $chatMember);
            $this->assertEquals($result[$i]['user']['id'], $chatMember->user->id);
            $this->assertEquals($result[$i]['status'], $chatMember->status);
        }
    }

    /**
     * @return array
     */
    public function buildResultDataProvider(): array
    {
        $chatMembers = [
            [
                'user' => [
                    'id' => 42,
                    'first_name' => 'FirstName',
                    'last_name'  => 'LastName',
                    'username'   => 'usrname'
                ],
                'status' => ChatMember::STATUS_CREATOR,
            ],
            [
                'user' => [
                    'id' => 43,
                    'first_name' => 'FirstName2',
                    'last_name'  => 'LastName2',
                    'username'   => 'usrname2'
                ],
                'status' => ChatMember::STATUS_ADMINISTRATOR
            ]
        ];

        return [
            [$chatMembers]
        ];
    }
}
