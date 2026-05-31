<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

/**
 * @psalm-external-mutation-free
 */
class MethodDefinition
{
    /**
     * @var ParameterDefinition[]
     */
    private array $parameters = [];

    private ?ParameterTypeDefinition $returnTypeDefinition = null;

    /**
     * @psalm-mutation-free
     */
    public function __construct(
        public readonly string $name,
        public readonly string $id,
        public readonly SectionDefinition $owner,
    ) {
    }

    /**
     * @psalm-external-mutation-free
     */
    public function addParameter(ParameterDefinition $parameterDefinition): void
    {
        $this->parameters[] = $parameterDefinition;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @psalm-external-mutation-free
     */
    public function setReturnTypeDefinition(ParameterTypeDefinition $returnTypeDefinition): void
    {
        $this->returnTypeDefinition = $returnTypeDefinition;
    }

    /**
     * @psalm-mutation-free
     */
    public function getReturnTypeDefinition(): ?ParameterTypeDefinition
    {
        return $this->returnTypeDefinition;
    }
}
