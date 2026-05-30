<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type;

use Steelbot\TelegramBotApi\Type\Basic\User;

readonly class CallbackQuery
{
    public string $id;

    public User $from;

    public ?Message $message;

    public ?string $inlineMessageId;

    public ?string $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->from = new User($data['from']);
        $this->message = isset($data['message']) ? new Message($data['message']) : null;
        $this->inlineMessageId = $data['inline_message_id'] ?? null;
        $this->data = $data['data'] ?? null;
    }
}
