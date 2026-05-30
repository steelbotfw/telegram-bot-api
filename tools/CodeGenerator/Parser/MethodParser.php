<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;

/**
 * @internal
 */
class MethodParser
{
    public function __construct(
        private readonly ParserHelper $parserHelper
    ) {
    }

    public function parse(Element $h4node, array $nodes): MethodDefinition
    {
        return new MethodDefinition($this->parserHelper->fetchSectionItemId($h4node));
    }
}
