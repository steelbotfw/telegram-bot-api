<?php

namespace Steelbot\Tests\TelegramBotApi\Type\Traits;

use Steelbot\TelegramBotApi\Type\KeyboardButton;

class KeyboardButtonTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetText()
    {
        $button = new KeyboardButton("Text one");

        $this->assertEquals("Text one", $button->getText());

        $button->setText("Text two");

        $this->assertEquals("Text two", $button->getText());
    }

    public function testGetSetRequestLocation()
    {
        $button = new KeyboardButton("Text one");

        $this->assertNull($button->getRequestLocation());

        $button->setRequestLocation(true);

        $this->assertTrue($button->getRequestLocation());
    }

    public function testGetSetRequestContact()
    {
        $this->markTestIncomplete();
    }

    public function testJsonSerialize()
    {
        $this->markTestIncomplete();
    }
}
