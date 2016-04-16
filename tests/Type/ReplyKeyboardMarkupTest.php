<?php

namespace Steelbot\Tests\TelegramBotApi\Type\Traits;

use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class ReplyKeyboardMarkupTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetKeyboard()
    {
        $markup = new ReplyKeyboardMarkup([]);

        $markup->setKeyboard([['1', '2', '3']]);

        $this->assertEquals([['1', '2', '3']], $markup->getKeyboard());
    }

    public function testAddKeyboardRow()
    {
        $markup = new ReplyKeyboardMarkup([['1', '2', '3']]);

        $this->assertCount(1, $markup->getKeyboard());

        $markup->addKeyboardRow(['4', '5', '6']);

        $this->assertEquals([
            ['1', '2', '3'],
            ['4', '5', '6']
        ], $markup->getKeyboard());
    }

    public function testAddKeyboardButton()
    {
        $markup = new ReplyKeyboardMarkup([['1', '2', '3']]);

        $markup->addKeyboardButton('4');

        $this->assertEquals([
            ['1', '2', '3', '4']
        ], $markup->getKeyboard());
    }

    public function testGetSetOneTimeKeyboard()
    {
        $markup = new ReplyKeyboardMarkup(['1', '2', '3']);

        $this->assertNull($markup->getOneTimeKeyboard());

        $markup->setOneTimeKeyboard(true);

        $this->assertTrue($markup->getOneTimeKeyboard());
    }

    public function testGetSetResizeKeyboard()
    {
        $markup = new ReplyKeyboardMarkup(['1', '2', '3']);

        $this->assertNull($markup->getResizeKeyboard());

        $markup->setResizeKeyboard(true);

        $this->assertTrue($markup->getResizeKeyboard());
    }

    public function testJsonSerialize()
    {
        $markup = new ReplyKeyboardMarkup(['1', '2', '3']);

        $expectedJson = json_encode([
            'keyboard' => ['1', '2', '3']
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($markup));

        $markup->setSelective(true);

        $expectedJson = json_encode([
            'keyboard' => ['1', '2', '3'],
            'selective' => 1
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($markup));
    }
}
