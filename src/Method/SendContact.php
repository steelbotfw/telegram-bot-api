<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;
use Steelbot\TelegramBotApi\Type\Message;

class SendContact extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use ReplyMarkupTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    public function __construct($chatId, string $phoneNumber, string $firstName)
    {
        $this->chatId = $chatId;
        $this->phoneNumber = $phoneNumber;
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return SendContact
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName():string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return SendContact
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return SendContact
     */
    public function setLastName(string $lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendContact';
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
            'phone_number' => $this->phoneNumber,
            'first_name' => $this->firstName,
        ];

        if ($this->lastName) {
            $params['last_name'] = $this->lastName;
        }

        if ($this->disableNotification !== null) {
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
