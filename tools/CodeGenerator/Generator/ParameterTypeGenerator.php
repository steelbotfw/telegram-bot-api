<?php


declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use LogicException;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;

readonly class ParameterTypeGenerator
{
    public function __construct(
        private TelegramTypeResolver $telegramTypeResolver
    ) {
    }

    public function injectParameterTypes(
        ClassType $class,
        ParameterDefinition $parameterDefinition,
    ): void {
        $resolvedType = $this->telegramTypeResolver->resolve($parameterDefinition->typeDefinition);

        foreach ($resolvedType->imports as $import) {
            $this->addImport($class, $import);
        }

        $parameter = $this->getOrCreateConstructor($class)
            ->addPromotedParameter($this->snakeToCamel($parameterDefinition->name))
            ->setNullable($parameterDefinition->isOptional)
            ->setType($resolvedType->nativeType);

        if ($resolvedType->phpDocType !== null) {
            $parameter->setComment(sprintf('@var %s', $resolvedType->phpDocType));
        }
    }

    private function getOrCreateConstructor(ClassType $class): Method
    {
        if ($class->hasMethod('__construct')) {
            return $class->getMethod('__construct');
        }

        return $class->addMethod('__construct');
    }

    private function addImport(ClassType $class, string $import): void
    {
        $namespace = $class->getNamespace();

        if (!$namespace instanceof PhpNamespace) {
            throw new LogicException(sprintf('Cannot add import "%s" to class without namespace.', $import));
        }

        $namespace->addUse($import);
    }

    private function snakeToCamel(string $string): string
    {
        return $string
                |> strtolower(...)
                |> (static fn($x) => ucwords($x, '_'))
                |> (static fn($x) => str_replace('_', '', $x))
                |> lcfirst(...);
    }
}
