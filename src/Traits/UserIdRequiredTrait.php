<?php

namespace Steelbot\TelegramBotApi\Traits;

trait UserIdRequiredTrait
{
    /**
     * @var int
     */
    protected $userId;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return $this
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
