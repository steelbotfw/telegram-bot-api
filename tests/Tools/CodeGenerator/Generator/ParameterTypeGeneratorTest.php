<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tests\Tools\CodeGenerator\Generator;

use Nette\PhpGenerator\PhpNamespace;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\ParameterTypeGenerator;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\ResolvedPhpType;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\TelegramTypeResolver;

class ParameterTypeGeneratorTest extends TestCase
{
    public function testInjectParameterTypes_WithRawPhpDocType_UsesRawComment(): void
    {
        $class = (new PhpNamespace('Test'))->addClass('Example');
        $parameterDefinition = $this->createParameterDefinition();
        $telegramTypeResolver = $this->createStub(TelegramTypeResolver::class);
        $telegramTypeResolver
            ->method('resolve')
            ->willReturn(new ResolvedPhpType(
                nativeTypes: ['array', 'string'],
                phpDocType: 'list<string>',
                rawPhpDocType: '@custom list<string>',
            ));

        $generator = new ParameterTypeGenerator($telegramTypeResolver);
        $generator->injectParameterTypes($class, $parameterDefinition);

        self::assertSame(
            '@custom list<string>',
            $class->getMethod('__construct')->getParameter('testParameter')->getComment(),
        );
        self::assertSame(
            'array|string',
            $class->getMethod('__construct')->getParameter('testParameter')->getType(),
        );
    }

    public function testInjectParameterTypes_WithPhpDocType_UsesVarComment(): void
    {
        $class = (new PhpNamespace('Test'))->addClass('Example');
        $parameterDefinition = $this->createParameterDefinition();
        $telegramTypeResolver = $this->createStub(TelegramTypeResolver::class);
        $telegramTypeResolver
            ->method('resolve')
            ->willReturn(new ResolvedPhpType(
                nativeTypes: ['array'],
                phpDocType: 'list<string>',
            ));

        $generator = new ParameterTypeGenerator($telegramTypeResolver);
        $generator->injectParameterTypes($class, $parameterDefinition);

        self::assertSame(
            '@var list<string>',
            $class->getMethod('__construct')->getParameter('testParameter')->getComment(),
        );
    }

    public function testInjectParameterTypes_WithOptionalParameter_AddsDefaultNull(): void
    {
        $class = (new PhpNamespace('Test'))->addClass('Example');
        $parameterDefinition = $this->createParameterDefinition(isOptional: true);
        $telegramTypeResolver = $this->createStub(TelegramTypeResolver::class);
        $telegramTypeResolver
            ->method('resolve')
            ->willReturn(new ResolvedPhpType(nativeTypes: ['Test\\InlineQuery']));

        $generator = new ParameterTypeGenerator($telegramTypeResolver);
        $generator->injectParameterTypes($class, $parameterDefinition);

        $parameter = $class->getMethod('__construct')->getParameter('testParameter');

        self::assertTrue($parameter->hasDefaultValue());
        self::assertNull($parameter->getDefaultValue());
    }

    private function createParameterDefinition(bool $isOptional = false): ParameterDefinition
    {
        $botApiDefinition = new BotApiDefinition();
        $sectionDefinition = new SectionDefinition('Getting updates', $botApiDefinition);
        $typeDefinition = new TypeDefinition('Update', '#update', $sectionDefinition);
        $type = new ParameterTypeDefinition();
        $type->addType('String', false);

        return new ParameterDefinition(
            name: 'test_parameter',
            typeDefinition: $type,
            description: '',
            isOptional: $isOptional,
            owner: $typeDefinition,
        );
    }
}
