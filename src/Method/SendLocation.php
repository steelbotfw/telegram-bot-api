<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\Message;

class SendLocation extends AbstractMethod implements \JsonSerializable
{
    protected $chatId;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    protected $disableNotification = false;
    protected $replyToMessageId = null;
    protected $replyMarkup = null;

    public function __construct($chatId, float $latitude, float $longitude)
    {
        $this->chatId = $chatId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return int|string
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @param string|int $chatId
     *
     * @return SendLocation
     */
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReplyMarkup()
    {
        return $this->replyMarkup;
    }

    /**
     * @param string|null $replyMarkup
     *
     * @return SendLocation
     */
    public function setReplyMarkup(string $replyMarkup = null)
    {
        $this->replyMarkup = $replyMarkup;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getReplyToMessageId()
    {
        return $this->replyToMessageId;
    }

    /**
     * @param null $replyToMessageId
     *
     * @return SendLocation
     */
    public function setReplyToMessageId(int $replyToMessageId = null)
    {
        $this->replyToMessageId = $replyToMessageId;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisableNotification()
    {
        return $this->disableNotification;
    }

    /**
     * @param boolean $disableNotification
     *
     * @return SendLocation
     */
    public function setDisableNotification(bool $disableNotification = false)
    {
        $this->disableNotification = $disableNotification;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param mixed $text
     *
     * @return SendLocation
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param mixed $text
     *
     * @return SendLocation
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendLocation';
    }

    /**
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return self::HTTP_POST;
    }

    /**
     * Get parameters for HTTP query.
     *
     * @return mixed
     */
    public function getParams(): array
    {
        $params = [
            'chat_id' => $this->chatId,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];

        if ($this->disableNotification) {
            $params['disable_notification'] = (int)$this->disableNotification;
        }

        if ($this->replyToMessageId) {
            $params['reply_to_message_id'] = $this->replyToMessageId;
        }

        return $params;
    }

    /**
     * Build result type from array of data.
     *
     * @param array $result
     *
     * @return object
     */
    public function buildResult($result)
    {
        return new Message($result);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $data = [];

        if ($this->replyMarkup) {
            $data['reply_markup'] = $this->replyMarkup;
        }

        return $data;
    }
}
