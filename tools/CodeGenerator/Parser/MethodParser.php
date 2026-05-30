<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;

/**
 * @internal
 */
class MethodParser
{
    public function __construct(
        private readonly ParserHelper $parserHelper
    ) {
    }

    public function parse(Element $h4node, array $nodes, SectionDefinition $sectionDefinition): MethodDefinition
    {
        return new MethodDefinition(
            trim($h4node->textContent),
            $this->parserHelper->fetchSectionItemId($h4node),
            $sectionDefinition,
        );
    }
}
