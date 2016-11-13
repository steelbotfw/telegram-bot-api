<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Traits\CaptionTrait,
    Traits\ChatIdRequiredTrait,
    Traits\DisableNotificationTrait,
    Traits\DurationOptionalTrait,
    Traits\JsonAttributesBuilderTrait,
    Traits\ReplyMarkupTrait,
    Traits\ReplyToMessageIdTrait,
    Type\Message
};

class SendVideo extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use DurationOptionalTrait;
    use CaptionTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;
    use ReplyMarkupTrait;

    use JsonAttributesBuilderTrait;
    /**
     * @var string
     */
    protected $video;

    /**
     * @var int|null
     */
    protected $width;

    /**
     * @var int|null
     */
    protected $height;

    public function __construct($chatId, string $video)
    {
        $this->chatId = $chatId;
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @param string $photo
     *
     * @return SendVideo
     */
    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     *
     * @return SendVideo
     */
    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     *
     * @return SendVideo
     */
    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendVideo';
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
            'video' => $this->video,
        ];

        $params = array_merge($params, $this->buildJsonAttributes([
            'duration' => $this->duration,
            'width' => $this->width,
            'height' => $this->height,
            'disable_notification' => $this->disableNotification,
            'reply_to_message_id' => $this->replyToMessageId
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
     *
     */
    public function jsonSerialize()
    {
        $data = $this->buildJsonAttributes([
            'reply_markup' => $this->replyMarkup,
            'caption' => $this->caption
        ]);

        return $data;
    }
}
