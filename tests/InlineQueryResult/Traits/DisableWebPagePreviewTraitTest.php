<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\InlineQueryResult\Traits\DisableWebPagePreviewTrait;

class DisableWebPagePreviewTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetDisableWebPagePreview()
    {
        $mock = $this->getMockForTrait(DisableWebPagePreviewTrait::class);

        $this->assertNull($mock->getDisableWebPagePreview());

        $mock->setDisableWebPagePreview(true);

        $this->assertTrue($mock->getDisableWebPagePreview());
    }
}
