<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use DOMElement;
use DOMNode;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @internal
 */
class HtmlParser
{
    private const array SECTIONS = [
      'Getting updates',
      'Available types',
      'Available methods',
      'Updating messages',
      'Stickers',
      'Inline mode',
      'Payments',
      'Telegram Passport',
      'Games',
    ];

    private readonly TypeParser $typeParser;
    private readonly MethodParser $methodParser;

    public function __construct(

        private readonly ParserHelper $parserHelper = new ParserHelper(),
    ) {
        $this->typeParser = new TypeParser($this->parserHelper);
        $this->methodParser = new MethodParser($this->parserHelper);
    }

    public function parse(string $html): BotApiDefinition
    {
        $crawler = new Crawler($html);

        $botApiDefinition = new BotApiDefinition();

        $crawler->filter('h3')->each(function (Crawler $h3Node): void {
            if (!in_array($h3Node->text(), self::SECTIONS, true)) {
                printf("Skipping section:\"%s\"\n", $h3Node->text());

                return;
            }
            printf("  Parsing section: \"%s\"\n", self::normalizeText($h3Node->text()));

            $node = $h3Node->getNode(0);
            if ($node === null) {
                return;
            }

            $contentNode = $node->nextSibling;
            $sectionsNodes = [];
            while ($contentNode !== null && $this->parserHelper->isH3Node($contentNode) === false) {
                $sectionsNodes[] = $contentNode;

                $contentNode = $contentNode->nextSibling;
            }
            $this->parseSection($h3Node->text(), $sectionsNodes);
        });

        return $botApiDefinition;
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
        $section = new SectionDefinition($title);
        printf("  Nodes in section %s: %d\n", $title, count($nodes));

        $itemNodes = [];
        foreach ($nodes as $node) {
            if ($node instanceof \DOMText) { // just spaces between tags
                assert(trim($node->wholeText) === '');
                continue;
            }

            if (count($itemNodes) === 0 && !$this->parserHelper->isH4Node($node)) {
                continue; // skip all nodes from the beginning until h4
            }

            if ($this->parserHelper->isH4Node($node) && count($itemNodes) > 0) {
                $section->addItem($this->parseSectionItem($itemNodes));
                $itemNodes = [];
            }

            printf("    Adding node: %s\n", $this->domNodeToString($node));
            $itemNodes[] = $node;
        }

        return $section;
    }

    /**
     * @param DOMNode[] $nodes
     *
     * @return TypeDefinition|MethodDefinition
     */
    private function parseSectionItem(array $nodes): TypeDefinition|MethodDefinition
    {
        $h4Node = array_shift($nodes);
        if (!$this->parserHelper->isH4Node($h4Node)) {
            var_dump($h4Node);
            throw new \LogicException(sprintf('Node %s must have a H4 tag', $h4Node::class));
        }
        /** @var DOMElement $h4Node */

        foreach ($nodes as $node) {
            printf("    Section item: %s\n", $node->nodeName);
        }

        $isFirstUpper = $h4Node->textContent
            |> trim(...)
            |> (static fn($x) => mb_substr($x, 0, 1))
            |> ctype_upper(...);

        return match ($isFirstUpper) {
            true => $this->typeParser->parse($h4Node, $nodes),
            false => $this->methodParser->parse($h4Node, $nodes),
        };
    }

    private function domNodeToString(DOMNode $node): string
    {
        $result = get_class($node).': ';

        switch (get_class($node)) {
            case \DOMText::class:
                $result .= '"' . $node->textContent . '"';
                break;

            case DOMElement::class:
                $result .= $node->tagName;
                break;

            default:
                $result .= '(unknown)';
                break;
        }

        return $result;
    }
}
