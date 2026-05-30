<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class MethodDefinition
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}