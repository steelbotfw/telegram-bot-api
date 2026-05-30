<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type\Reaction;

use Steelbot\TelegramBotApi\Enum\Emoji;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;
use JsonSerializable;

readonly class ReactionTypeEmoji implements ReactionTypeInterface, JsonSerializable
{
    use JsonAttributesBuilderTrait;

    private const string TYPE = 'emoji';

    public function __construct(
        private string|Emoji $emoji,
    ) {
    }

    public function getEmoji(): string|Emoji
    {
        return $this->emoji;
    }

    public function jsonSerialize(): array
    {
        return $this->buildJsonAttributes([
            'type' => self::TYPE,
            'emoji' => is_string($this->emoji) ? $this->emoji : $this->emoji->value
        ]);
    }
}