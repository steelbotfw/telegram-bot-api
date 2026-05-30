<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\LatLonRequiredTrait;

class LatLonRequiredTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

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
