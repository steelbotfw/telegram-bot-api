<?php

namespace Steelbot\Tests\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\InputMessageContent\InputLocationMessageContent;

class InputLocationMessageContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputLocationMessageContent
     */
    protected $inputMessageContent;

    public function setUp()
    {
        $this->inputMessageContent = new InputLocationMessageContent(12.3, 45.6);
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

    public function testJsonSerialize()
    {
        $json = json_encode($this->inputMessageContent);
        $result = json_decode($json, true);

        $this->assertEquals(12.3, $result['latitude']);
        $this->assertEquals(45.6, $result['longitude']);
    }
}
