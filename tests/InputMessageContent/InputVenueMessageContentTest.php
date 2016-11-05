<?php

namespace Steelbot\Tests\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\InputMessageContent\InputVenueMessageContent;

class InputVenueMessageContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputVenueMessageContent
     */
    protected $inputMessageContent;

    public function setUp()
    {
        $this->inputMessageContent = new InputVenueMessageContent(12.3, 45.6, 'venue title', 'venue address');
    }

    public function testGetSetLatitude()
    {
        $this->assertEquals(12.3, $this->inputMessageContent->getLatitude());
        $this->inputMessageContent->setLatitude(11.6);
        $this->assertEquals(11.6, $this->inputMessageContent->getLatitude());
    }

    public function testGetSetLongitude()
    {
        $this->assertEquals(45.6, $this->inputMessageContent->getLongitude());
        $this->inputMessageContent->setLongitude(23.4);
        $this->assertEquals(23.4, $this->inputMessageContent->getLongitude());
    }

    public function testGetSetTitle()
    {
        $this->assertEquals('venue title', $this->inputMessageContent->getTitle());
        $this->inputMessageContent->setTitle('another venue title');
        $this->assertEquals('another venue title', $this->inputMessageContent->getTitle());
    }

    public function testGetSetAddress()
    {
        $this->assertEquals('venue address', $this->inputMessageContent->getAddress());
        $this->inputMessageContent->setAddress('another venue address');
        $this->assertEquals('another venue address', $this->inputMessageContent->getAddress());
    }

    public function testGetSetFoursquareId()
    {
        $this->assertNull($this->inputMessageContent->getFoursquareId());
        $this->inputMessageContent->setFoursquareId('4square-id');
        $this->assertEquals('4square-id', $this->inputMessageContent->getFoursquareId());

        $this->inputMessageContent->setFoursquareId(null);
        $this->assertNull($this->inputMessageContent->getFoursquareId());
    }

    public function testJsonSerialize()
    {
        $this->inputMessageContent->setFoursquareId('4square-id');

        $json = json_encode($this->inputMessageContent);
        $result = json_decode($json, true);

        $this->assertEquals(12.3, $result['latitude']);
        $this->assertEquals(45.6, $result['longitude']);
        $this->assertEquals('venue title', $result['title']);
        $this->assertEquals('venue address', $result['address']);
        $this->assertEquals('4square-id', $result['foursquare_id']);
    }
}
