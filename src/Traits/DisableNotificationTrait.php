<?php

namespace Steelbot\TelegramBotApi\Traits;

trait DisableNotificationTrait
{
    /**
     * @var bool|null
     */
    protected $disableNotification;

    /**
     * @return bool|null
     */
    public function getDisableNotification()
    {
        return $this->disableNotification;
    }

    /**
     * @param boolean $disableNotification
     *
     * @return self
     */
    public function setDisableNotification(bool $disableNotification = null)
    {
        $this->disableNotification = $disableNotification;

        return $this;
    }
}
