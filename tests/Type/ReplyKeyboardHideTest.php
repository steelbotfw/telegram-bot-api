<?php

namespace Steelbot\Tests\TelegramBotApi\Type\Traits;

use Steelbot\TelegramBotApi\Type\ReplyKeyboardHide;

class ReplyKeyboardHideTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonSerialize()
    {
        $type = new ReplyKeyboardHide();

        $json = [
            'hide_keyboard' => true
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($json, JSON_UNESCAPED_UNICODE),
            json_encode($type, JSON_UNESCAPED_UNICODE)
        );

        $json = [
            'hide_keyboard' => true,
            'selective' => false
        ];


        $type->setSelective(false);
        $this->assertJsonStringEqualsJsonString(
            json_encode($json, JSON_UNESCAPED_UNICODE),
            json_encode($type, JSON_UNESCAPED_UNICODE)
        );
    }
}
