<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApiDev\CodeGenerator\Parser;

use DOMElement;
use DOMNode;
use Steelbot\TelegramBotApiDev\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApiDev\CodeGenerator\Definition\SectionDefinition;
use Symfony\Component\DomCrawler\Crawler;

class HtmlParser
{
    public function parse(string $html): BotApiDefinition
    {
        $crawler = new Crawler($html);

        $botApiDefinition = new BotApiDefinition();

        $crawler->filter('h3')->each(function (Crawler $h3Node): void {
            printf("  Parsing section: \"%s\"\n", self::normalizeText($h3Node->text()));

            $node = $h3Node->getNode(0);
            if ($node === null) {
                return;
            }

            $contentNode = $node->nextSibling;
            while ($contentNode !== null && self::isH3Node($contentNode) === false) {
                $nodeHtml = self::renderNode($contentNode);
                if ($nodeHtml !== null) {
                    echo $nodeHtml, "\n";
                }

                $contentNode = $contentNode->nextSibling;
            }
        });

        return $botApiDefinition;
    }

    private static function isH3Node(DOMNode $node): bool
    {
        return $node instanceof DOMElement && strtolower($node->tagName) === 'h3';
    }

    private static function renderNode(DOMNode $node): ?string
    {
        if ($node->nodeType === XML_TEXT_NODE && trim($node->textContent) === '') {
            return null;
        }

        $html = $node->ownerDocument?->saveHTML($node);
        if (is_string($html) && trim($html) !== '') {
            return trim($html);
        }

        $text = self::normalizeText($node->textContent);

        return $text === '' ? null : $text;
    }

    private static function normalizeText(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text)) ?? '';
    }

    /**
     * @param string $title
     * @param DOMNode[]  $nodes
     *
     * @return SectionDefinition
     */
    private function parseSection(string $title, array $nodes): SectionDefinition
    {
        $section = new SectionDefinition();

        return $section;
    }
}
