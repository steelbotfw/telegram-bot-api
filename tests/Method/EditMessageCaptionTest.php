<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\EditMessageCaption,
    Type\Message,
    Type\ReplyKeyboardMarkup
};

class EditMessageCaptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new EditMessageCaption();
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
    public function testBuildResult()
    {
        $this->markTestIncomplete();
    }

    /**
     * @return array
     */
    public function buildResultDataProvider(): array
    {
        return [];
    }

    public function testJsonSerialize()
    {
        $method = new EditMessageCaption();
        $method->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']))
            ->setCaption('Some caption');

        $json = [
            'caption' => 'Some caption',
            'reply_markup' => ['keyboard' => ['1', '2', '3']]
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new EditMessageCaption();

        $this->assertEquals(EditMessageCaption::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new EditMessageCaption();

        $this->assertEquals('editMessageCaption', $method->getMethodName());
    }

    public function testGetSetChatId()
    {
        $method = new EditMessageCaption();

        $this->assertNull($method->getChatId());

        $method->setChatId('@chatid');

        $this->assertEquals('@chatid', $method->getChatId());
    }
}
