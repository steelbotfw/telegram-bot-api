<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\DisableWebPagePreviewTrait;

class DisableWebPagePreviewTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetDisableWebPagePreview()
    {
        $mock = $this->getMockForTrait(DisableWebPagePreviewTrait::class);

        $this->assertNull($mock->getDisableWebPagePreview());

        $mock->setDisableWebPagePreview(true);

        $this->assertTrue($mock->getDisableWebPagePreview());
    }
}
