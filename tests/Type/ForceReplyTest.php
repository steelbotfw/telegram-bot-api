<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Type;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Type\ForceReply;

class ForceReplyTest extends TestCase
{
    public function testJsonSerialize()
    {
        $type = new ForceReply();

        $json = [
            'force_reply' => true
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($json, JSON_UNESCAPED_UNICODE),
            json_encode($type, JSON_UNESCAPED_UNICODE)
        );

        $json = [
            'force_reply' => true,
            'selective' => false
        ];


        $type->setSelective(false);
        $this->assertJsonStringEqualsJsonString(
            json_encode($json, JSON_UNESCAPED_UNICODE),
            json_encode($type, JSON_UNESCAPED_UNICODE)
        );
    }
}
