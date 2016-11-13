<?php

namespace Steelbot\Tests\TelegramBotApi\Type;

use Steelbot\TelegramBotApi\Type\InlineKeyboardButton;

class InlineKeyboardButtonTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonSerialize()
    {
        $button = new InlineKeyboardButton('button1');

        $button->setUrl('http://localhost');

        $expectedJson = json_encode([
            'text' => 'button1',
            'url' => 'http://localhost'
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));

        $button->setCallbackData('callback data');

        $expectedJson = json_encode([
            'text' => 'button1',
            'callback_data' => 'callback data'
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));

        $button->setSwitchInlineQuery('switch inline query');

        $expectedJson = json_encode([
            'text' => 'button1',
            'switch_inline_query' => 'switch inline query'
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));
    }

    public function testOneOptionalFieldMustBePresented()
    {
        $button = new InlineKeyboardButton('button1');

        $this->expectException(\LogicException::class);

        json_encode($button);
    }
}
