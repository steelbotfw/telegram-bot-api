<?php


declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use LogicException;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Type;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;

readonly class ParameterTypeGenerator
{
    /**
     * @psalm-mutation-free
     */
    public function __construct(
        private TelegramTypeResolver $telegramTypeResolver
    ) {
    }

    public function injectParameterTypes(
        ClassType $class,
        ParameterDefinition $parameterDefinition,
    ): void {
        $resolvedType = $this->resolve($parameterDefinition);

        foreach ($resolvedType->imports as $import) {
            $this->addImport($class, $import);
        }

        $parameter = $this->getOrCreateConstructor($class)
            ->addPromotedParameter($this->snakeToCamel($parameterDefinition->name))
            ->setNullable($parameterDefinition->isOptional)
            ->setType(Type::union(...$resolvedType->nativeTypes));

        if ($parameterDefinition->isOptional) {
            $parameter->setDefaultValue(null);
        }

        $comment = $resolvedType->rawPhpDocType
            ?? ($resolvedType->phpDocType !== null ? sprintf('@var %s', $resolvedType->phpDocType) : null);

        if ($comment !== null) {
            $parameter->setComment($comment);
        }
    }

    /**
     * @psalm-mutation-free
     */
    public function resolve(ParameterDefinition $parameterDefinition): ResolvedPhpType
    {
        return $this->resolveTypeDefinition($parameterDefinition->typeDefinition);
    }

    /**
     * @psalm-mutation-free
     */
    public function resolveTypeDefinition(ParameterTypeDefinition $typeDefinition): ResolvedPhpType
    {
        return $this->telegramTypeResolver->resolve($typeDefinition);
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

    /**
     * @psalm-pure
     */
    private function snakeToCamel(string $string): string
    {
        return $string
                |> strtolower(...)
                |> (static fn($x) => ucwords($x, '_'))
                |> (static fn($x) => str_replace('_', '', $x))
                |> lcfirst(...);
    }
}
