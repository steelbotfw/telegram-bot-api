<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Dom\HTMLDocument;
use Dom\Node;
use Dom\Text;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

/**
 * @internal
 */
class HtmlParser
{
    private const array SECTIONS = [
      'Getting updates',
        /* TODO
      'Available types',
      'Available methods',
      'Updating messages',
      'Stickers',
      'Inline mode',
      'Payments',
      'Telegram Passport',
      'Games',
        */
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
        $document = HTMLDocument::createFromString($html, LIBXML_NOERROR);

        $botApiDefinition = new BotApiDefinition();

        foreach ($document->querySelectorAll('h3') as $h3Node) {
            if (!$h3Node instanceof Element) {
                continue;
            }

            $sectionTitle = self::normalizeText($h3Node->textContent);
            if (!in_array($sectionTitle, self::SECTIONS, true)) {
                printf("Skipping section:\"%s\"\n", $sectionTitle);

                continue;
            }
            printf("  Parsing section: \"%s\"\n", $sectionTitle);

            $contentNode = $h3Node->nextSibling;
            $sectionsNodes = [];
            while ($contentNode !== null && $this->parserHelper->isH3Node($contentNode) === false) {
                $sectionsNodes[] = $contentNode;

                $contentNode = $contentNode->nextSibling;
            }
            $botApiDefinition->addSection($this->parseSection($sectionTitle, $sectionsNodes));
        }

        return $botApiDefinition;
    }

    private static function normalizeText(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text)) ?? '';
    }

    /**
     * @param string $title
     * @param Node[]  $nodes
     *
     * @return SectionDefinition
     */
    private function parseSection(string $title, array $nodes): SectionDefinition
    {
        $section = new SectionDefinition($title);
        printf("  Nodes in section %s: %d\n", $title, count($nodes));

        $itemNodes = [];
        foreach ($nodes as $node) {
            if ($node instanceof Text) { // just spaces between tags
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

        if (count($itemNodes) > 0) {
            $section->addItem($this->parseSectionItem($itemNodes));
        }

        return $section;
    }

    /**
     * @param Node[] $nodes
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
        /** @var Element $h4Node */

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

    private function domNodeToString(Node $node): string
    {
        $result = get_class($node).': ';

        if ($node instanceof Text) {
            $result .= '"' . $node->textContent . '"';
        } elseif ($node instanceof Element) {
            $result .= $node->tagName;
        } else {
            $result .= '(unknown)';
        }

        return $result;
    }
}
