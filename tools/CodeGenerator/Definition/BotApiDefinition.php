<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class BotApiDefinition
{
    private array $sections = [];

    public function addSection(SectionDefinition $section): void
    {
        $this->sections[] = $section;
    }

    public function getSections(): array
    {
        return $this->sections;
    }


}