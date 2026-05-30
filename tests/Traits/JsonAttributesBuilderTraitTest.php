<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;

class AttributesBuilderExample
{
    use JsonAttributesBuilderTrait;

    protected string $property1 = 'value1';

    protected string $property2 = 'value2';

    protected int $property3;

    public function buildAttributes(): array
    {
        return $this->buildJsonAttributes([
            'property_one' => $this->property1,
            'property_two' => $this->property2,
        ]);
    }
}

class JsonAttributesBuilderTraitTest extends TestCase
{
    public function testBuildJsonAttributesSuccess(): void
    {
        $object = new AttributesBuilderExample();

        $attributes = $object->buildAttributes();

        $this->assertCount(2, $attributes);
        $this->assertEquals('value1', $attributes['property_one']);
        $this->assertEquals('value2', $attributes['property_two']);
    }
}
