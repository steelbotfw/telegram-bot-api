<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tests\Tools\CodeGenerator\Parser;

use Dom\HTMLDocument;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser\ParserHelper;

class ParserHelperTest extends TestCase
{
    #[DataProvider('tdWithValueTypeDefinitionProvider')]
    public function testParseValueType_Always_ReturnsCorrectResult(
        string $html,
        array $expected,
    ): void {
        $parserHelper = new ParserHelper();

        $tdNode = HTMLDocument::createFromString(
            "<!doctype html><html><body><table><tr>{$html}</tr></table></body></html>"
        )->querySelector('td');

        $this->assertSame(
            $expected,
            $this->exportValueType($parserHelper->parseValueType($tdNode))
        );
    }

    public static function tdWithValueTypeDefinitionProvider(): array
    {
        return [
            [
                'html' => '<td>Integer</td>',
                'expected' => [
                    'types' => ['Integer'],
                ]
            ],
            [
                'html' => '<td>Array of <a href="#id">ID</a></td>',
                'expected' => [
                    'types' => ['#id[]'],
                ]
            ],
        ];
    }

    private function exportValueType(ParameterTypeDefinition $valueTypeDefinition): array
    {
        return [
            'types' => $valueTypeDefinition->getTypes(),
        ];
    }
}
