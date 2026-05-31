<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

/**
 * @psalm-external-mutation-free
 */
readonly class TelegramTypeFqcnResolver
{
    /**
     * @psalm-mutation-free
     */
    public function __construct(
        private string $baseNamespace = 'Steelbot\\TelegramBotApi\\Type',
    ) {
    }

    /**
     * @psalm-mutation-free
     */
    public function resolve(TypeDefinition $typeDefinition): string
    {
        return sprintf(
            '%s\\%s\\%s',
            trim($this->baseNamespace, '\\'),
            $typeDefinition->owner->getSectionId(),
            $typeDefinition->name,
        );
    }
}
