<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use DOMElement;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeFieldDefinition;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @internal
 */
readonly class TypeParser
{
    public function __construct(
        private ParserHelper $parserHelper
    ) {
    }

    public function parse(DOMElement $h4Node, array $nodes): TypeDefinition
    {
        $typeDefinition = new TypeDefinition($this->parserHelper->fetchSectionItemId($h4Node));

        foreach ($nodes as $node) {
            if ($this->parserHelper->isTableNode($node)) {
                /** @var DOMElement $node */
                return $this->parseTable($node, $typeDefinition);
            }
        }

        return $typeDefinition;
    }

    private function assertTableHeaderIsValid(DOMElement $table): void
    {
        $crawler = new Crawler($table);

        $headerValues = array_map(
            fn (string $text) => trim($text),
            $crawler->filter('thead tr')->eq(0)->filter('th')->extract(['_text']),
        );

        assert($headerValues === ['Field', 'Type', 'Description']);
    }

    private function parseTable(DOMelement $table, TypeDefinition $typeDefinition): TypeDefinition
    {
        $this->assertTableHeaderIsValid($table);

        $crawler = new Crawler($table);
        $crawler->filter('tbody tr')->each(function (Crawler $tr) use ($typeDefinition) {
            $tds = $tr->filter('td');

            $typeDefinition->addField(
                new TypeFieldDefinition(
                    $tds->eq(0)->text(''),
                    $this->parserHelper->parseValueType($tds->eq(1)),
                    $tds->eq(2)->text(),
                    $this->detectIsOptional($tds->eq(2)),
                )
            );
        });
    }

    private function detectIsOptional(Crawler $td): bool
    {

    }
}
