<?php


declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use Composer\Autoload\ClassLoader;
use LanguageServerProtocol\DiagnosticRelatedInformation;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\PsrPrinter;
use Nette\PhpGenerator\Type;
use RuntimeException;
use SplFileInfo;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

readonly class ParameterTypeGenerator
{
    private function injectParameterTypes(
        ClassType $class,
        ParameterDefinition $parameterDefinition, // Type or Method parameter
        BotApiDefinition $botApiDefinition,
    ): void {
        var_dump($parameterDefinition->typeDefinition->getTypes());

        $parameter = $class->getMethod('__construct')
            ->addPromotedParameter($this->snakeToCamel($parameterDefinition->name))
            ->setNullable($parameterDefinition->isOptional)
            ->setType(ParameterTypeGenerator::class);

        $types = [];
        foreach ($parameterDefinition->typeDefinition->getTypes() as $telegramTypeName) {
            if ($this->isObjectType($telegramTypeName)) { // object type

            } else { // scalar type
                $type = match ($telegramTypeName) {
                    'Integer' => Type::Int,
                    'Boolean' => Type::Bool,
                    'String' => Type::String,
                    default => throw new RuntimeException(
                        sprintf(
                            "Unknown telegram scalar type %s for parameter %s",
                            $telegramTypeName,
                            $parameterDefinition->name
                        )
                    )
                };
                $parameter->setType($type);
            }
        }

        switch (count($types)) {
            case 1:
                $parameter->setType($types[0]);
                break;

            case 0:
                throw new \LogicException("Parameter {$parameterDefinition->name} has no types.");

            default:
                $parameter->setType(Type::union(...$types));
        }
    }

    private function snakeToCamel($string)
    {
        return $string
                |> strtolower(...)
                |> (static fn($x) => ucwords($x, '_'))
                |> (static fn($x) => str_replace('_', '', $x))
                |> lcfirst(...);
    }

    private function isArrayType(string $typeName): bool
    {
        return str_ends_with($typeName, '[]');
    }

    private function isObjectType(string $typeName): bool
    {
        return str_starts_with($typeName, '#');
    }
}