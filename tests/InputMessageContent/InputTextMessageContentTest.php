<?php

namespace Steelbot\Tests\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\InputMessageContent\InputTextMessageContent;
use Steelbot\TelegramBotApi\ParseMode;

class InputTextMessageContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputTextMessageContent
     */
    protected $inputMessageContent;

    public function setUp()
    {
        $this->inputMessageContent = new InputTextMessageContent('message text');
    }

    public function testGetSetMessageText()
    {
        $this->assertEquals('message text', $this->inputMessageContent->getMessageText());
        $this->inputMessageContent->setMessageText('another message text');
        $this->assertEquals('another message text', $this->inputMessageContent->getMessageText());
    }

    public function testJsonSerialize()
    {
        $this->inputMessageContent->setMessageText('MessageText');
        $this->inputMessageContent->setDisableWebPagePreview(true);
        $this->inputMessageContent->setParseMode(ParseMode::HTML);

        $json = json_encode($this->inputMessageContent);
        $result = json_decode($json, true);

        $this->assertEquals('MessageText', $result['message_text']);
        $this->assertEquals(1, $result['disable_web_page_preview']);
        $this->assertEquals(ParseMode::HTML, $result['parse_mode']);
    }
}
