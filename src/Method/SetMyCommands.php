<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;
use Steelbot\TelegramBotApi\Type\BotCommand;

/**
 * @extends AbstractMethod<bool>
 */
final class SetMyCommands extends AbstractMethod implements JsonSerializable
{
    /**
     * @param list<BotCommand> $commands
     */
    public function __construct(
        private readonly array $commands,
    ) {
    }

    /**
     * @return list<BotCommand>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    public function getMethodName(): string
    {
        return 'setMyCommands';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getParams(): array
    {
        return [];
    }

    /**
     * @param bool $result
     */
    public function buildResult($result): bool
    {
        return $result;
    }

    /**
     * @return array{commands: list<BotCommand>}
     */
    public function jsonSerialize(): array
    {
        return ['commands' => $this->commands];
    }
}
