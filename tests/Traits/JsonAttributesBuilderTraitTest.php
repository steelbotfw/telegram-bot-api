<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;

class AttributesBuilderExample
{
    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $property1 = 'value1';

    /**
     * @var string
     */
    protected $property2 = 'value2';

    /**
     * @var int
     */
    protected $property3;

    public function buildAttributes()
    {
        return $this->buildJsonAttributes([
            'property_one' => $this->property1,
            'property_two' => $this->property2,
        ]);
    }
}

class JsonAttributesBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildJsonAttributesSuccess()
    {
        $object = new AttributesBuilderExample();

        $attributes = $object->buildAttributes();

        $this->assertCount(2, $attributes);
        $this->assertEquals('value1', $attributes['property_one']);
        $this->assertEquals('value2', $attributes['property_two']);
    }
}
