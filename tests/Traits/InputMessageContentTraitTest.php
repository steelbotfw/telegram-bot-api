<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\InputMessageContentTrait;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InputMessageContentTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetInputMessageContent()
    {
        /** @var InputMessageContentTrait $mock */
        $mock = $this->getMockForTrait(InputMessageContentTrait::class);

        $this->assertNull($mock->getInputMessageContent());

        $inputMessageContentMock = $this->getMock(InputMessageContentInterface::class);

        $mock->setInputMessageContent($inputMessageContentMock);

        $this->assertSame($mock->getInputMessageContent(), $inputMessageContentMock);
    }
}
