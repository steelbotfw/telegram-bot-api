<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetUpdates;
use Steelbot\TelegramBotApi\Type\Chat;
use Steelbot\TelegramBotApi\Type\Update;

class GetUpdatesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetUpdates(1);

        $this->assertEquals('getUpdates', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetUpdates(1);

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetUpdates(1);

        $params = [
            'offset' => 1,
            'limit' => 5,
            'timeout' => 30
        ];
        $this->assertEquals($params, $method->getParams());
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($result)
    {
        $method = new GetUpdates(1);

        $updates = $method->buildResult($result);

        $this->assertCount(1, $updates);

        $update = array_pop($updates);
        $this->assertInstanceOf(Update::class, $update);
        $this->assertEquals($result[0]['update_id'], $update->updateId);
    }

    public function buildResultDataProvider(): array
    {
        $messageUpdate = [
            [
                'update_id' => 79947337,
                'message' => [
                    'message_id' => 4768,
                    'from' => [
                        'id' => 104442434,
                        'first_name' => 'FirstName',
                        'last_name' => 'LastName',
                        'username' => 'UserName'
                    ],

                    'date' => 123456789,

                    'chat' => [
                        'id' => 12121212,
                        'type' => Chat::TYPE_PRIVATE,
                        'title' => null,
                        'username' => 'ChatUserName',
                        'first_name' => 'ChatFirstName',
                        'last_name' => 'ChatLastName'
                    ],

                    'text' => 'hello',
                    'location' => null,
                    'new_chat_participant' => null,
                    'left_chat_participant' => null,
                    'new_chat_title' => null,
                ],

                'inlineQuery' => null,
                'chosenInlineResult' => null,

            ],
        ];

        // @todo inlineQuery

        // @todo chosenInlineResult

        return [
            [$messageUpdate]
        ];
    }
}
