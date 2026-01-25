<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{Enum\Emoji,
    Traits\ChatIdRequiredTrait,
    Traits\JsonAttributesBuilderTrait,
    Type\Reaction\ReactionTypeEmoji,
    Type\Reaction\ReactionTypeInterface};

/**
 * @extends AbstractMethod<bool>
 */
class SetMessageReaction extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use JsonAttributesBuilderTrait;

    private array|Emoji|null $reaction = null;

    /**
     * @param ReactionTypeInterface[]|Emoji|null $reaction
     */
    public function __construct(
        int|string $chatId,
        private int $messageId,
        array|Emoji|null $reaction = null,
        private ?bool $isBig = null
    ) {
        $this->chatId = $chatId;
        if ($reaction instanceof Emoji) {
            $reaction = [new ReactionTypeEmoji($reaction)];
        }

        $this->reaction = $reaction;
    }

    public function getMethodName(): string
    {
        return 'setMessageReaction';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    /**
     * Get parameters for HTTP query.
     *
     * @return mixed
     */
    public function getParams(): ?array
    {
        return null;
    }

    /**
     * @return bool
     */
    public function buildResult($result): object|array|bool|int
    {
        return $result;
    }

    /**
     *
     */
    public function jsonSerialize(): array
    {
        return $this->buildJsonAttributes([
            'chat_id' => $this->chatId,
            'message_id'     => $this->messageId,
            'reaction'    => $this->reaction,
            'is_big'        => $this->isBig,
        ]);
    }
}
