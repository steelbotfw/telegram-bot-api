<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type;

use DateTimeImmutable;
use Steelbot\TelegramBotApi\Type\Basic\User;

final readonly class ChatMemberUpdated
{
    public Chat $chat;

    public User $from;

    public DateTimeImmutable $date;

    public ChatMember $oldChatMember;

    public ChatMember $newChatMember;

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(array $data)
    {
        $this->chat = new Chat($data['chat']);
        $this->from = new User($data['from']);
        $this->date = new DateTimeImmutable('@' . $data['date']);
        $this->oldChatMember = new ChatMember($data['old_chat_member']);
        $this->newChatMember = new ChatMember($data['new_chat_member']);
    }
}
