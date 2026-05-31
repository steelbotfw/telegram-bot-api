<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tests\Tools\CodeGenerator\Generator;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\ResolvedPhpType;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\TelegramTypeFqcnResolver;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\TelegramTypeResolver;

class TelegramTypeResolverTest extends TestCase
{
    public function testResolve_WithScalarAndArrayOfObject_ReturnsUnionWithObjectImport(): void
    {
        $botApiDefinition = new BotApiDefinition();
        $sectionDefinition = new SectionDefinition('Getting updates', $botApiDefinition);
        $photoSizeDefinition = new TypeDefinition('PhotoSize', '#photosize', $sectionDefinition);
        $sectionDefinition->addItem($photoSizeDefinition);
        $botApiDefinition->addSection($sectionDefinition);

        $parameterTypeDefinition = new ParameterTypeDefinition();
        $parameterTypeDefinition->addType('Integer', false);
        $parameterTypeDefinition->addType('#photosize', true);

        $resolver = new TelegramTypeResolver(
            $botApiDefinition,
            new TelegramTypeFqcnResolver('Test'),
        );

        $resolvedType = $resolver->resolve($parameterTypeDefinition);

        self::assertEquals(
            new ResolvedPhpType(
                nativeTypes: ['int', 'array'],
                phpDocType: 'int|list<Test\\Update\\PhotoSize>',
                imports: ['Test\\Update\\PhotoSize'],
            ),
            $resolvedType,
        );
    }

    public function testResolve_WithUnknownObject_ReturnsMixed(): void
    {
        $parameterTypeDefinition = new ParameterTypeDefinition();
        $parameterTypeDefinition->addType('#message', false);

        $resolver = new TelegramTypeResolver(
            new BotApiDefinition(),
            new TelegramTypeFqcnResolver('Test'),
        );

        self::assertEquals(
            new ResolvedPhpType(
                nativeTypes: ['mixed'],
                rawPhpDocType: 'mixed Unknown type: #message',
            ),
            $resolver->resolve($parameterTypeDefinition),
        );
    }
}
