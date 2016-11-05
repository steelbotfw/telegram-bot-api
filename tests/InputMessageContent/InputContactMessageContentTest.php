<?php

namespace Steelbot\Tests\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\InputMessageContent\InputContactMessageContent;

class InputContacteMessageContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputContactMessageContent
     */
    protected $inputMessageContent;

    public function setUp()
    {
        $this->inputMessageContent = new InputContactMessageContent('+0123456789', 'First Name');
    }

    public function testGetSetPhoneNumber()
    {
        $this->assertEquals('+0123456789', $this->inputMessageContent->getPhoneNumber());
        $this->inputMessageContent->setPhoneNumber('+9876543210');
        $this->assertEquals('+9876543210', $this->inputMessageContent->getPhoneNumber());
    }

    public function testGetSetFirstName()
    {
        $this->assertEquals('First Name', $this->inputMessageContent->getFirstName());
        $this->inputMessageContent->setFirstName('First Name2');
        $this->assertEquals('First Name2', $this->inputMessageContent->getFirstName());
    }

    public function testGetSetLastName()
    {
        $this->assertNull($this->inputMessageContent->getLastName());
        $this->inputMessageContent->setLastName('Last Name');
        $this->assertEquals('Last Name', $this->inputMessageContent->getLastName());

        $this->inputMessageContent->setLastName(null);
        $this->assertNull($this->inputMessageContent->getLastName());
    }

    public function testJsonSerialize()
    {
        $this->inputMessageContent->setLastName('Last Name');

        $json = json_encode($this->inputMessageContent);
        $result = json_decode($json, true);

        $this->assertEquals('+0123456789', $result['phone_number']);
        $this->assertEquals('First Name', $result['first_name']);
        $this->assertEquals('Last Name', $result['last_name']);
    }
}
