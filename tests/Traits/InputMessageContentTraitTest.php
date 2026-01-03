<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\InputMessageContentTrait;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InputMessageContentTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetInputMessageContent()
    {
        /** @var InputMessageContentTrait $mock */
        $mock = $this->getMockForTrait(InputMessageContentTrait::class);

        $this->assertNull($mock->getInputMessageContent());

        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);

        $mock->setInputMessageContent($inputMessageContentMock);

        $this->assertSame($mock->getInputMessageContent(), $inputMessageContentMock);
    }
}
