<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Type;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Type\InlineKeyboardButton;
use Steelbot\TelegramBotApi\Type\InlineKeyboardMarkup;

class InlineKeyboardMarkupTest extends TestCase
{
    public function testJsonSerialize()
    {
        $markup = new InlineKeyboardMarkup([
            [
                (new InlineKeyboardButton('button1'))->setUrl('http://localhost')
            ]
        ]);

        $button1 = new \stdClass();
        $button1->text = 'button1';
        $button1->url = 'http://localhost';

        $expectedJson = json_encode([
            'inline_keyboard' => [
                [
                    $button1
                ]
            ]
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($markup));
    }
}
