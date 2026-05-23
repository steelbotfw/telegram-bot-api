<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type;

use InvalidArgumentException;
use JsonSerializable;

final readonly class BotCommand implements JsonSerializable
{
    public function __construct(
        private string $command,
        private string $description,
    ) {
        if (!preg_match('/^[a-z0-9_]{1,32}$/', $command)) {
            throw new InvalidArgumentException('Bot command must contain 1-32 lowercase letters, digits or underscores.');
        }

        $descriptionLength = mb_strlen($description);
        if ($descriptionLength < 1 || $descriptionLength > 256) {
            throw new InvalidArgumentException('Bot command description must contain 1-256 characters.');
        }
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array{command: string, description: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'command' => $this->command,
            'description' => $this->description,
        ];
    }
}
