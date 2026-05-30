<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Type;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Type\KeyboardButton;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class ReplyKeyboardMarkupTest extends TestCase
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

    public function testAddKeyboardButton_EmptyKeyboard_AddsButton(): void
    {
        $markup = new ReplyKeyboardMarkup([[]]);

        $markup->addKeyboardButton('1');

        $this->assertEquals(
            [
                'keyboard' => [['1']],
            ],
            $markup->jsonSerialize()
        );
    }

    public function testAddKeyboardButton(): void
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

    public function testJsonSerialize_Always_SerializesObject(): void
    {
        $markup = new ReplyKeyboardMarkup([
            ['1'],
            [new KeyboardButton('2'),'3']
        ]);
        $markup->setSelective(true);

        $this->assertSame(
            [
                'keyboard' => [
                    ['1'],
                    [['text' => '2'], '3']
                ],
                'selective' => true,
            ],
            $markup->jsonSerialize()
        );
    }
}
