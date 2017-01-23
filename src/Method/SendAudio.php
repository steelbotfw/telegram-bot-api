<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Traits\CaptionTrait,
    Traits\ChatIdRequiredTrait,
    Traits\DisableNotificationTrait,
    Traits\JsonAttributesBuilderTrait,
    Traits\ReplyMarkupTrait,
    Traits\ReplyToMessageIdTrait,
    Type\Message
};

class SendAudio extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;
    use ReplyMarkupTrait;
    use CaptionTrait;
    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $audio;

    /**
     * @var int|null
     */
    protected $duration;

    /**
     * @var string|null
     */
    protected $performer;

    /**
     * @var string|null
     */
    protected $title;

    public function __construct($chatId, string $audio)
    {
        $this->chatId = $chatId;
        $this->audio = $audio;
    }

    /**
     * @return string
     */
    public function getAudio(): string
    {
        return $this->audio;
    }

    /**
     * @return int|null
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int|null $duration
     *
     * @return SendAudio
     */
    public function setDuration(int $duration = null): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPerformer()
    {
        return $this->performer;
    }

    /**
     * @param null|string $performer
     *
     * @return SendAudio
     */
    public function setPerformer(string $performer = null)
    {
        $this->performer = $performer;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return SendAudio
     */
    public function setTitle(string $title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendAudio';
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
            'audio' => $this->audio,
        ];

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
     *
     */
    public function jsonSerialize()
    {
        $data = $this->buildJsonAttributes([
            'reply_markup' => $this->replyMarkup,
            'duration'     => $this->duration,
            'performer'    => $this->performer,
            'title'        => $this->title,
            'caption'      => $this->caption
        ]);

        return $data;
    }
}
