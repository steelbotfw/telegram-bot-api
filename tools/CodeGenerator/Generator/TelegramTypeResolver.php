<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use Closure;
use LogicException;
use RuntimeException;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

readonly class TelegramTypeResolver
{
    /**
     * @var Closure(TypeDefinition): class-string
     */
    private Closure $typeFqcnResolver;

    /**
     * @param callable(TypeDefinition): class-string $typeFqcnResolver
     */
    public function __construct(
        private BotApiDefinition $botApiDefinition,
        callable $typeFqcnResolver,
    ) {
        $this->typeFqcnResolver = Closure::fromCallable($typeFqcnResolver);
    }

    public function resolve(ParameterTypeDefinition $typeDefinition): ResolvedPhpType
    {
        $nativeTypes = [];
        $phpDocTypes = [];
        $imports = [];

        foreach ($typeDefinition->getTypes() as $telegramTypeName) {
            $resolvedType = $this->resolveSingleType($telegramTypeName);

            $nativeTypes[] = $resolvedType->nativeType;
            $phpDocTypes[] = $resolvedType->phpDocType ?? $resolvedType->nativeType;
            $imports = [...$imports, ...$resolvedType->imports];
        }

        if ($nativeTypes === []) {
            throw new LogicException('Parameter type definition has no types.');
        }

        $nativeTypes = array_values(array_unique($nativeTypes));
        $phpDocTypes = array_values(array_unique($phpDocTypes));
        $imports = array_values(array_unique($imports));

        $nativeType = implode('|', $nativeTypes);
        $phpDocType = $phpDocTypes === $nativeTypes ? null : implode('|', $phpDocTypes);

        return new ResolvedPhpType($nativeType, $phpDocType, $imports);
    }

    private function resolveSingleType(string $telegramTypeName): ResolvedPhpType
    {
        [$baseTypeName, $arrayDepth] = $this->parseArrayType($telegramTypeName);
        $resolvedBaseType = $this->resolveBaseType($baseTypeName);

        if ($arrayDepth === 0) {
            return $resolvedBaseType;
        }

        return new ResolvedPhpType(
            nativeType: 'array',
            phpDocType: $this->wrapArrayPhpDocType(
                $resolvedBaseType->phpDocType ?? $resolvedBaseType->nativeType,
                $arrayDepth
            ),
            imports: $resolvedBaseType->imports,
        );
    }

    private function resolveBaseType(string $telegramTypeName): ResolvedPhpType
    {
        if (str_starts_with($telegramTypeName, '#')) {
            return $this->resolveObjectType($telegramTypeName);
        }

        return new ResolvedPhpType($this->resolveScalarType($telegramTypeName));
    }

    private function resolveObjectType(string $typeId): ResolvedPhpType
    {
        if (!$this->botApiDefinition->hasItem($typeId)) {
            return new ResolvedPhpType('mixed');
        }

        $definition = $this->botApiDefinition->getItem($typeId);

        if (!$definition instanceof TypeDefinition) {
            throw new LogicException(sprintf('Expected type definition for "%s", got "%s".', $typeId, $definition::class));
        }

        $fqcn = ltrim(($this->typeFqcnResolver)($definition), '\\');

        return new ResolvedPhpType(
            nativeType: $this->extractShortClassName($fqcn),
            imports: [$fqcn],
        );
    }

    private function resolveScalarType(string $telegramTypeName): string
    {
        return match ($telegramTypeName) {
            'Boolean' => 'bool',
            'Float', 'Double' => 'float',
            'Integer' => 'int',
            'String' => 'string',
            'True' => 'true',
            default => throw new RuntimeException(sprintf('Unknown Telegram scalar type "%s".', $telegramTypeName)),
        };
    }

    /**
     * @return array{0: string, 1: int}
     */
    private function parseArrayType(string $telegramTypeName): array
    {
        $arrayDepth = 0;
        $telegramTypeName = trim($telegramTypeName);

        while (str_ends_with($telegramTypeName, '[]')) {
            $arrayDepth++;
            $telegramTypeName = substr($telegramTypeName, 0, -2);
        }

        return [trim($telegramTypeName), $arrayDepth];
    }

    private function wrapArrayPhpDocType(string $typeName, int $arrayDepth): string
    {
        for ($i = 0; $i < $arrayDepth; $i++) {
            $typeName = sprintf('list<%s>', $typeName);
        }

        return $typeName;
    }

    private function extractShortClassName(string $fqcn): string
    {
        $lastNamespaceSeparatorPosition = strrpos($fqcn, '\\');

        if ($lastNamespaceSeparatorPosition === false) {
            return $fqcn;
        }

        return substr($fqcn, $lastNamespaceSeparatorPosition + 1);
    }
}
