<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Dom\Node;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;

/**
 * @internal
 */
class ParserHelper
{
    public function fetchSectionItemId(Element $h4Node): string
    {
        assert($this->isH4Node($h4Node));

        $aNodes = $h4Node->getElementsByTagName('a');
        assert($aNodes->count() === 1);

        return $aNodes->item(0)->getAttribute('name');

    }

    public function isPNode(Node $node): bool
    {
        return $node instanceof Element && strtolower($node->tagName) === 'p';
    }

    public function isH3Node(Node $node): bool
    {
        return $node instanceof Element && strtolower($node->tagName) === 'h3';
    }

    public function isH4Node(Node $node): bool
    {
        return $node instanceof Element && strtolower($node->tagName) === 'h4';
    }

    public function isBlockquoteNode(Node $node): bool
    {
        return $node instanceof Element && strtolower($node->tagName) === 'blockquote';
    }

    public function isTableNode(Node $node): bool
    {
        return $node instanceof Element && strtolower($node->tagName) === 'table';
    }

    public function isTdNode(Node $node): bool
    {
        return $node instanceof Element && strtolower($node->tagName) === 'td';
    }

    public function parseValueType(Element $tdNode): ParameterTypeDefinition
    {
        assert($this->isTdNode($tdNode));

        $vtd = new ParameterTypeDefinition();

        $valueText = preg_replace('/\s+/', ' ', trim($tdNode->textContent)) ?? '';
        $isArray = str_starts_with($valueText, 'Array of');

        $a = $tdNode->querySelector('a');
        if ($a) {
            $typeName = $a->getAttribute('href');
        } else {
            $typeName = $isArray ? substr($valueText, strlen('Array of')) : $valueText;
        }

        $vtd->addType($typeName, $isArray);

        // todo parse OR definition

        // todo parse Array of Array of

        return $vtd;
    }
}
