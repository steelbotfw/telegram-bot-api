<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use LogicException;
use RuntimeException;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

/**
 * @psalm-external-mutation-free
 */
readonly class TelegramTypeResolver
{
    /**
     * @psalm-mutation-free
     */
    public function __construct(
        private BotApiDefinition $botApiDefinition,
        private TelegramTypeFqcnResolver $typeFqcnResolver,
    ) {
    }

    /**
     * @psalm-mutation-free
     */
    public function resolve(ParameterTypeDefinition $typeDefinition): ResolvedPhpType
    {
        $nativeTypes = [];
        $phpDocTypes = [];
        $rawPhpDocTypes = [];
        $imports = [];

        foreach ($typeDefinition->getTypes() as $telegramTypeName) {
            $resolvedType = $this->resolveSingleType($telegramTypeName);

            $nativeTypes = [...$nativeTypes, ...$resolvedType->nativeTypes];
            $phpDocTypes[] = $resolvedType->phpDocType ?? implode('|', $resolvedType->nativeTypes);
            if ($resolvedType->rawPhpDocType !== null) {
                $rawPhpDocTypes[] = $resolvedType->rawPhpDocType;
            }
            $imports = [...$imports, ...$resolvedType->imports];
        }

        if ($nativeTypes === []) {
            throw new LogicException('Parameter type definition has no types.');
        }

        $nativeTypes = array_values(array_unique($nativeTypes));
        $phpDocTypes = array_values(array_unique($phpDocTypes));
        $rawPhpDocTypes = array_values(array_unique($rawPhpDocTypes));
        $imports = array_values(array_unique($imports));

        $phpDocType = $phpDocTypes === $nativeTypes ? null : implode('|', $phpDocTypes);
        $rawPhpDocType = $rawPhpDocTypes === [] ? null : implode("\n", $rawPhpDocTypes);

        return new ResolvedPhpType($nativeTypes, $phpDocType, $imports, $rawPhpDocType);
    }

    /**
     * @psalm-mutation-free
     */
    private function resolveSingleType(string $telegramTypeName): ResolvedPhpType
    {
        [$baseTypeName, $arrayDepth] = $this->parseArrayType($telegramTypeName);
        $resolvedBaseType = $this->resolveBaseType($baseTypeName);

        if ($arrayDepth === 0) {
            return $resolvedBaseType;
        }

        return new ResolvedPhpType(
            nativeTypes: ['array'],
            phpDocType: $this->wrapArrayPhpDocType(
                $resolvedBaseType->phpDocType ?? implode('|', $resolvedBaseType->nativeTypes),
                $arrayDepth
            ),
            imports: $resolvedBaseType->imports,
            rawPhpDocType: $resolvedBaseType->rawPhpDocType,
        );
    }

    /**
     * @psalm-mutation-free
     */
    private function resolveBaseType(string $telegramTypeName): ResolvedPhpType
    {
        if (str_starts_with($telegramTypeName, '#')) {
            return $this->resolveObjectType($telegramTypeName);
        }

        return new ResolvedPhpType([$this->resolveScalarType($telegramTypeName)]);
    }

    /**
     * @psalm-mutation-free
     */
    private function resolveObjectType(string $typeId): ResolvedPhpType
    {
        if (!$this->botApiDefinition->hasItem($typeId)) {
            return new ResolvedPhpType(
                nativeTypes: ['mixed'],
                rawPhpDocType: 'mixed Unknown type: ' . $typeId,
            );
        }

        $definition = $this->botApiDefinition->getItem($typeId);

        if (!$definition instanceof TypeDefinition) {
            throw new LogicException(sprintf('Expected type definition for "%s", got "%s".', $typeId, $definition::class));
        }

        $fqcn = ltrim($this->typeFqcnResolver->resolve($definition), '\\');

        return new ResolvedPhpType(
            nativeTypes: [$fqcn],
            imports: [$fqcn],
        );
    }

    /**
     * @psalm-pure
     */
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
     *
     * @psalm-pure
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

    /**
     * @psalm-pure
     */
    private function wrapArrayPhpDocType(string $typeName, int $arrayDepth): string
    {
        for ($i = 0; $i < $arrayDepth; $i++) {
            $typeName = sprintf('list<%s>', $typeName);
        }

        return $typeName;
    }
}
