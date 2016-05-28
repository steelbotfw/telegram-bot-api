<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * ChatMember
 */
class ChatMember
{
    const STATUS_CREATOR = 'creator';

    const STATUS_ADMINISTRATOR = 'administrator';

    const STATUS_MEMBER = 'memeber';

    const STATUS_LEFT = 'left';

    const STATUS_KICKED = 'kicked';

    /**
     * Information about the user.
     *
     * @var User
     */
    public $user;

    /**
     *  The member's status in the chat.
     * @var string
     */
    public $status;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->user = new User($data['user']);
        $this->status = $data['status'];
    }
}
