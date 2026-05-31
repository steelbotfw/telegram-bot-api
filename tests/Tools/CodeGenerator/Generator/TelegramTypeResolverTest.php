<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tests\Tools\CodeGenerator\Generator;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\ResolvedPhpType;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\TelegramTypeResolver;

class TelegramTypeResolverTest extends TestCase
{
    public function testResolve_WithScalarAndArrayOfObject_ReturnsUnionWithObjectImport(): void
    {
        $botApiDefinition = new BotApiDefinition();
        $sectionDefinition = new SectionDefinition('Available types', $botApiDefinition);
        $photoSizeDefinition = new TypeDefinition('PhotoSize', '#photosize', $sectionDefinition);
        $sectionDefinition->addItem($photoSizeDefinition);
        $botApiDefinition->addSection($sectionDefinition);

        $parameterTypeDefinition = new ParameterTypeDefinition();
        $parameterTypeDefinition->addType('Integer', false);
        $parameterTypeDefinition->addType('#photosize', true);

        $resolver = new TelegramTypeResolver(
            $botApiDefinition,
            static fn (TypeDefinition $typeDefinition): string => 'Test\\' . $typeDefinition->name,
        );

        $resolvedType = $resolver->resolve($parameterTypeDefinition);

        self::assertEquals(
            new ResolvedPhpType(
                nativeType: 'int|array',
                phpDocType: 'int|list<PhotoSize>',
                imports: ['Test\\PhotoSize'],
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
            static fn (TypeDefinition $typeDefinition): string => 'Test\\' . $typeDefinition->name,
        );

        self::assertEquals(
            new ResolvedPhpType('mixed'),
            $resolver->resolve($parameterTypeDefinition),
        );
    }
}
