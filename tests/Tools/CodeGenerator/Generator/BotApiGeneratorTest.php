<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tests\Tools\CodeGenerator\Generator;

use Composer\Autoload\ClassLoader;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\BotApiGenerator;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\ParameterTypeGenerator;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\TelegramTypeFqcnResolver;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator\TelegramTypeResolver;

class BotApiGeneratorTest extends TestCase
{
    public function testGenerate_WithMethodDefinition_GeneratesMutableJsonMethodClass(): void
    {
        $baseDir = sys_get_temp_dir() . '/telegram-bot-api-generator-' . bin2hex(random_bytes(4));
        self::assertTrue(mkdir($baseDir, 0777, true));

        $classLoader = array_values(ClassLoader::getRegisteredLoaders())[0] ?? null;
        self::assertInstanceOf(ClassLoader::class, $classLoader);
        $classLoader->addPsr4('Generated\\', $baseDir . DIRECTORY_SEPARATOR);

        $botApiDefinition = new BotApiDefinition();
        $sectionDefinition = new SectionDefinition('Getting updates', $botApiDefinition);
        $messageDefinition = new TypeDefinition('Message', '#message', $sectionDefinition);
        $methodDefinition = new MethodDefinition('sendMessage', '#sendmessage', $sectionDefinition);
        $methodDefinition->addParameter($this->createParameter('chat_id', 'Integer', false, $methodDefinition));
        $methodDefinition->addParameter($this->createParameter('text', 'String', false, $methodDefinition));
        $methodDefinition->addParameter($this->createParameter('disable_notification', 'Boolean', true, $methodDefinition));

        $returnType = new ParameterTypeDefinition();
        $returnType->addType('#message', false);
        $methodDefinition->setReturnTypeDefinition($returnType);

        $sectionDefinition->addItem($messageDefinition);
        $sectionDefinition->addItem($methodDefinition);
        $botApiDefinition->addSection($sectionDefinition);

        $generator = new BotApiGenerator(
            $baseDir,
            new ParameterTypeGenerator(
                new TelegramTypeResolver(
                    $botApiDefinition,
                    new TelegramTypeFqcnResolver('Generated\\Type'),
                ),
            ),
        );

        $generator->generate($botApiDefinition);

        $generatedCode = file_get_contents(
            $baseDir . '/Method/Update/SendMessage.php',
        );
        self::assertIsString($generatedCode);

        self::assertStringContainsString('class SendMessage extends \Steelbot\TelegramBotApi\Method\AbstractMethod implements \JsonSerializable', $generatedCode);
        self::assertStringContainsString('public function __construct(', $generatedCode);
        self::assertStringContainsString('private int $chatId,', $generatedCode);
        self::assertStringContainsString('private string $text,', $generatedCode);
        self::assertStringContainsString('private ?bool $disableNotification = null', $generatedCode);
        self::assertStringContainsString('public function getDisableNotification(): ?bool', $generatedCode);
        self::assertStringContainsString('public function setDisableNotification(?bool $disableNotification = null): self', $generatedCode);
        self::assertStringContainsString("return 'sendMessage';", $generatedCode);
        self::assertStringContainsString('return self::HTTP_POST;', $generatedCode);
        self::assertStringContainsString('return [];', $generatedCode);
        self::assertStringContainsString("'chat_id' => \$this->chatId,", $generatedCode);
        self::assertStringContainsString("if (\$this->disableNotification !== null) {", $generatedCode);
        self::assertStringContainsString("return new Message(\$result);", $generatedCode);
    }

    private function createParameter(
        string $name,
        string $type,
        bool $isOptional,
        MethodDefinition $methodDefinition,
    ): ParameterDefinition {
        $typeDefinition = new ParameterTypeDefinition();
        $typeDefinition->addType($type, false);

        return new ParameterDefinition(
            name: $name,
            typeDefinition: $typeDefinition,
            description: '',
            isOptional: $isOptional,
            owner: $methodDefinition,
        );
    }
}
