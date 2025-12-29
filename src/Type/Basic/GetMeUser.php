<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type\Basic;

/**
 * This type is returned in the /getMe method
 */
readonly class GetMeUser extends User
{
    public ?bool $canJoinGroups;
    public ?bool $canReadAllGroupMessages;
    public ?bool $supportsInlineQueries;
    public ?bool $canConnectToBusiness;
    public ?bool $hasMainWebApp;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->canJoinGroups = $data['can_join_groups'] ?? null;
        $this->canReadAllGroupMessages = $data['can_read_all_group_messages'] ?? null;
        $this->supportsInlineQueries = $data['supports_inline_queries'] ?? null;
        $this->canConnectToBusiness = $data['can_connect_to_business'] ?? null;
        $this->hasMainWebApp = $data['has_main_web_app'] ?? null;
    }
}
