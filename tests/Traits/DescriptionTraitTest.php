<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\DescriptionTrait;

class DescriptionTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSetDescription()
    {
        $mock = $this->getMockForTrait(DescriptionTrait::class);

        $this->assertNull($mock->getDescription());

        $mock->setDescription('Some description');

        $this->assertEquals('Some description', $mock->getDescription());
    }
}
