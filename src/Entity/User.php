<?php

namespace Steelbot\TelegramBotApi\Entity;

/**
 * User entity
 */
class User
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string|null
     */
    public $firstName;

    /**
     * @var string|null
     */
    public $lastName;

    /**
     * @var string|null
     */
    public $username;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->firstName = $data['first_name'] ?? null;
        $this->lastName  = $data['last_name']  ?? null;
        $this->username  = $data['username']   ?? null;
    }
}
