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
        $button = new KeyboardButton("Text one");

        $this->assertNull($button->getRequestContact());

        $button->setRequestContact(true);

        $this->assertTrue($button->getRequestContact());
    }

    public function testJsonSerialize()
    {
        $button = new KeyboardButton("Text one");

        $expectedJson = json_encode([
            'text' => 'Text one'
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));

        $button->setRequestContact(true);
        $button->setRequestLocation(true);

        $expectedJson = json_encode([
            'text' => 'Text one',
            'request_location' => 1
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));
    }
}
