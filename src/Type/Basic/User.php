<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type\Basic;

use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;

/**
 * User entity
 */
readonly class User
{
    public int $id;
    public bool $isBot;
    public string $firstName;
    public ?string $lastName;
    public ?string $username;
    public ?string $languageCode;
    public ?bool $isPremium;
    public ?bool $addedToAttachmentMenu;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->isBot = $data['is_bot'];
        $this->firstName = $data['first_name'] ?? throw new TelegramBotApiException("First name cannot be NULL");
        $this->lastName  = $data['last_name']  ?? null;
        $this->username  = $data['username']   ?? null;
        $this->languageCode  = $data['language_code']   ?? null;
        $this->isPremium  = $data['is_premium'] ?? null;
        $this->addedToAttachmentMenu = $data['added_to_attachment_menu'] ?? null;
    }
}
