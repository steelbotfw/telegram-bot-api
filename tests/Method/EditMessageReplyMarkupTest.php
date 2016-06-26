<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\EditMessageReplyMarkup,
    Type\Message,
    Type\ReplyKeyboardMarkup
};

class EditMessageReplyMarkupTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new EditMessageReplyMarkup();
        $method->setChatId(11)
            ->setMessageId(42);

        $params = $method->getParams();

        $this->assertArrayHasKey('chat_id', $params);
        $this->assertEquals(11, $params['chat_id']);
        $this->assertArrayHasKey('message_id', $params);
        $this->assertEquals(42, $params['message_id']);

        $method->setInlineMessageId(43);

        $params = $method->getParams();

        $this->assertArrayHasKey('inline_message_id', $params);
        $this->assertEquals(43, $params['inline_message_id']);
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($data)
    {
        $method = new EditMessageReplyMarkup();

        $message = $method->buildResult($data);

        if (is_array($data)) {
            $this->assertInstanceOf(Message::class, $message);
            $this->assertEquals($data['message_id'], $message->messageId);
            $this->assertEquals($data['from']['id'], $message->from->id);
            $this->assertEquals($data['chat']['id'], $message->chat->id);
            $this->assertEquals($data['edit_date'], $message->editDate->format('U'));
        } elseif (is_bool($data)) {
            $this->assertTrue($message);
        }
    }

    /**
     * @return array
     */
    public function buildResultDataProvider(): array
    {
        $data = [
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
            'edit_date' => 1456600096,
            'text' => 'Hello!'
        ];

        return [
            [$data],
            [true]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new EditMessageReplyMarkup();
        $method->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $json = [
            'reply_markup' => ['keyboard' => ['1', '2', '3']]
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new EditMessageReplyMarkup();

        $this->assertEquals(EditMessageReplyMarkup::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new EditMessageReplyMarkup();

        $this->assertEquals('editMessageReplyMarkup', $method->getMethodName());
    }

    public function testGetSetChatId()
    {
        $method = new EditMessageReplyMarkup();

        $this->assertNull($method->getChatId());

        $method->setChatId('@chatid');

        $this->assertEquals('@chatid', $method->getChatId());
    }
}
