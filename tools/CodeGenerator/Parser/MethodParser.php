<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser;

use Dom\Element;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterTypeDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;

/**
 * @internal
 */
class MethodParser
{
    /**
     * @psalm-mutation-free
     */
    public function __construct(
        private readonly ParserHelper $parserHelper
    ) {
    }

    public function parse(Element $h4node, array $nodes, SectionDefinition $sectionDefinition): MethodDefinition
    {
        $methodDefinition = new MethodDefinition(
            trim($h4node->textContent),
            $this->parserHelper->fetchSectionItemId($h4node),
            $sectionDefinition,
        );

        foreach ($nodes as $node) {
            if ($this->parserHelper->isTableNode($node)) {
                /** @var Element $node */
                $this->parseTable($node, $methodDefinition);

                continue;
            }

            if ($node instanceof Element && $methodDefinition->getReturnTypeDefinition() === null) {
                $returnTypeDefinition = $this->parseReturnType($node);
                if ($returnTypeDefinition !== null) {
                    $methodDefinition->setReturnTypeDefinition($returnTypeDefinition);
                }
            }
        }

        return $methodDefinition;
    }

    private function assertTableHeaderIsValid(Element $table): void
    {
        $headerValues = [];
        foreach ($table->querySelectorAll('thead tr:first-child th') as $th) {
            $headerValues[] = trim($th->textContent);
        }

        assert($headerValues === ['Parameter', 'Type', 'Required', 'Description']);
    }

    private function parseTable(Element $table, MethodDefinition $methodDefinition): void
    {
        $this->assertTableHeaderIsValid($table);

        foreach ($table->querySelectorAll('tbody tr') as $tr) {
            if (!$tr instanceof Element) {
                continue;
            }

            $tds = $tr->querySelectorAll('td');
            assert($tds->count() === 4);

            $nameNode = $tds->item(0);
            $typeNode = $tds->item(1);
            $requiredNode = $tds->item(2);
            $descriptionNode = $tds->item(3);
            assert($nameNode instanceof Element);
            assert($typeNode instanceof Element);
            assert($requiredNode instanceof Element);
            assert($descriptionNode instanceof Element);

            $methodDefinition->addParameter(
                new ParameterDefinition(
                    $nameNode->textContent,
                    $this->parserHelper->parseValueType($typeNode),
                    $descriptionNode->textContent,
                    $this->detectIsOptional($requiredNode),
                    $methodDefinition,
                )
            );
        }
    }

    /**
     * @psalm-mutation-free
     */
    private function detectIsOptional(Element $td): bool
    {
        return strtolower(trim($td->textContent)) !== 'yes';
    }

    private function parseReturnType(Element $node): ?ParameterTypeDefinition
    {
        $text = self::normalizeText($node->textContent);
        if (!preg_match('/\breturns?\b/i', $text)) {
            return null;
        }

        $returnTypeDefinition = new ParameterTypeDefinition();
        $isArray = preg_match('/\breturns?\s+(?:an?\s+)?array of\b/i', $text) === 1;

        $typeLink = $node->querySelector('a[href^="#"]');
        if ($typeLink instanceof Element) {
            $href = $typeLink->getAttribute('href');
            if ($href === null) {
                return null;
            }

            $returnTypeDefinition->addType($href, $isArray);

            return $returnTypeDefinition;
        }

        foreach (['True', 'Boolean', 'Integer', 'Float', 'Double', 'String'] as $scalarType) {
            if (preg_match(sprintf('/\b%s\b/i', preg_quote($scalarType, '/')), $text) === 1) {
                $returnTypeDefinition->addType($scalarType, $isArray);

                return $returnTypeDefinition;
            }
        }

        return null;
    }

    /**
     * @psalm-pure
     */
    private static function normalizeText(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text)) ?? '';
    }
}
