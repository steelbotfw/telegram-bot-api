<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Contact
 */
class Contact
{
    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string|null
     */
    public $lastName;

    /**
     * @var integer|null
     */
    public $userId;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->phoneNumber = $data['phone_number'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'] ?? null;
        $this->userId = $data['user_id'] ?? null;
    }
}
