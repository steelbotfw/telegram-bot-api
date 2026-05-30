<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Dom\Node;
use DOMElement;
use DOMNode;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ValueTypeDefinition;
use Symfony\Component\DomCrawler\Crawler;
use Dom;

/**
 * @internal
 */
class ParserHelper
{
    public function fetchSectionItemId(DOMElement $h4Node): string
    {
        assert(!$this->isH4Node($h4Node));

        $aNodes = $h4Node->getElementsByTagName('a');
        assert($aNodes->count() === 1);

        return $aNodes->item(0)->getAttribute('name');

    }

    public function isPNode(DOMNode $node): bool
    {
        return $node instanceof DOMElement && strtolower($node->tagName) === 'p';
    }

    public function isH3Node(DOMNode $node): bool
    {
        return $node instanceof DOMElement && strtolower($node->tagName) === 'h3';
    }

    public function isH4Node(DOMNode $node): bool
    {
        return $node instanceof DOMElement && strtolower($node->tagName) === 'h4';
    }

    public function isBlockquoteNode(DOMNode $node): bool
    {
        return $node instanceof DOMElement && strtolower($node->tagName) === 'blockquote';
    }

    public function isTableNode(DOMNode $node): bool
    {
        return $node instanceof DOMElement && strtolower($node->tagName) === 'table';
    }

    public function isTdNode(Dom\Node $node): bool
    {
        return $node instanceof Dom\Element && strtolower($node->tagName) === 'td';
    }

    public function parseValueType(Element $tdNode): ValueTypeDefinition
    {
        assert($this->isTdNode($tdNode));

        $vtd = new ValueTypeDefinition();

        $valueText = $tdNode->firstChild->nodeValue;
        $isArray = trim($valueText) === 'Array of';

        $a = $tdNode->querySelector('a');
        if ($a) {
            $typeName = $a->getAttribute('href');
        } else {
            $typeName = $isArray ? str_replace('Array of', '', $valueText) : $valueText;
        }

        $vtd->addType($typeName, $isArray);

        // todo parse OR definition

        return $vtd;
    }
}
