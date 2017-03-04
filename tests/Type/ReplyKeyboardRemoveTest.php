<?php

namespace Steelbot\Tests\TelegramBotApi\Type\Traits;

use Steelbot\TelegramBotApi\Type\ReplyKeyboardRemove;

class ReplyKeyboardRemoveTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonSerialize()
    {
        $type = new ReplyKeyboardRemove();

        $json = [
            'remove_keyboard' => true
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($json, JSON_UNESCAPED_UNICODE),
            json_encode($type, JSON_UNESCAPED_UNICODE)
        );

        $json = [
            'remove_keyboard' => true,
            'selective' => false
        ];


        $type->setSelective(false);
        $this->assertJsonStringEqualsJsonString(
            json_encode($json, JSON_UNESCAPED_UNICODE),
            json_encode($type, JSON_UNESCAPED_UNICODE)
        );
    }
}
