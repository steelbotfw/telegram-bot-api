<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;
use Steelbot\TelegramBotApi\Traits\LatLonRequiredTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;
use Steelbot\TelegramBotApi\Traits\TitleRequiredTrait;
use Steelbot\TelegramBotApi\Type\Message;

class SendVenue extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use LatLonRequiredTrait;
    use TitleRequiredTrait;
    use ReplyMarkupTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $foursquareId;

    /**
     * SendVenue constructor.
     *
     * @param        $chatId
     * @param float  $latitude
     * @param float  $longitude
     * @param string $title
     * @param string $address
     */
    public function __construct($chatId, float $latitude, float $longitude, string $title, string $address)
    {
        $this->chatId = $chatId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->title = $title;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFoursquareId(): ?string
    {
        return $this->foursquareId;
    }

    /**
     * @param null|string $foursquareId
     *
     * @return SendVenue
     */
    public function setFoursquareId(?string $foursquareId)
    {
        $this->foursquareId = $foursquareId;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendVenue';
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
            'longitude' => $this->longitude,
        ];

        $params = array_merge($params, $this->buildJsonAttributes([
            'foursquare_id' => $this->foursquareId,
            'disable_notification' => $this->disableNotification,
            'reply_to_message_id' => $this->replyToMessageId,
        ]));


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
    public function jsonSerialize()
    {
        $data = [
            'title' => $this->title,
            'address' => $this->address
        ];


        $data = array_merge($data, $this->buildJsonAttributes([
            'reply_markup' => $this->replyMarkup
        ]));

        return $data;
    }
}
