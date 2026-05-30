<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeFieldDefinition;

/**
 * @internal
 */
readonly class TypeParser
{
    public function __construct(
        private ParserHelper $parserHelper
    ) {
    }

    public function parse(Element $h4Node, array $nodes): TypeDefinition
    {
        $typeDefinition = new TypeDefinition(
            $h4Node->textContent,
            $this->parserHelper->fetchSectionItemId($h4Node)
        );

        foreach ($nodes as $node) {
            if ($this->parserHelper->isTableNode($node)) {
                /** @var Element $node */
                return $this->parseTable($node, $typeDefinition);
            }
        }

        return $typeDefinition;
    }

    private function assertTableHeaderIsValid(Element $table): void
    {
        $headerValues = [];
        foreach ($table->querySelectorAll('thead tr:first-child th') as $th) {
            $headerValues[] = trim($th->textContent);
        }

        assert($headerValues === ['Field', 'Type', 'Description']);
    }

    private function parseTable(Element $table, TypeDefinition $typeDefinition): TypeDefinition
    {
        $this->assertTableHeaderIsValid($table);

        foreach ($table->querySelectorAll('tbody tr') as $tr) {
            if (!$tr instanceof Element) {
                continue;
            }

            $tds = $tr->querySelectorAll('td');
            assert($tds->count() === 3);

            $nameNode = $tds->item(0);
            $typeNode = $tds->item(1);
            $descriptionNode = $tds->item(2);
            assert($nameNode instanceof Element);
            assert($typeNode instanceof Element);
            assert($descriptionNode instanceof Element);

            $typeDefinition->addField(
                new TypeFieldDefinition(
                    $nameNode->textContent,
                    $this->parserHelper->parseValueType($typeNode),
                    $descriptionNode->textContent,
                    $this->detectIsOptional($descriptionNode),
                )
            );
        }

        return $typeDefinition;
    }

    private function detectIsOptional(Element $td): bool
    {
        return str_starts_with(trim($td->textContent), 'Optional.');
    }
}
