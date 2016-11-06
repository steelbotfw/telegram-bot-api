<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\LatLonRequiredTrait;

class LatLonRequiredTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetLatitude()
    {
        $mock = $this->getMockForTrait(LatLonRequiredTrait::class);
        $mock->setLatitude(12.3);

        $this->assertEquals(12.3, $mock->getLatitude());
    }

    public function testGetSetLatitudeNullFails()
    {
        $mock = $this->getMockForTrait(LatLonRequiredTrait::class);

        $this->expectException(\TypeError::class);
        $mock->setLatitude();
        $mock->setLatitude(null);

        $mock->getLatitude();
    }

    public function testGetSetLongitude()
    {
        $mock = $this->getMockForTrait(LatLonRequiredTrait::class);
        $mock->setLongitude(45.6);

        $this->assertEquals(45.6, $mock->getLongitude());
    }

    public function testGetSetLongitudeNullFails()
    {
        $mock = $this->getMockForTrait(LatLonRequiredTrait::class);

        $this->expectException(\TypeError::class);
        $mock->setLongitude();
        $mock->setLongitude(null);

        $mock->getLongitude();
    }
}
