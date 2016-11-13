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

class SendVoice extends AbstractMethod implements \JsonSerializable
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
    protected $voice;

    public function __construct($chatId, string $voice)
    {
        $this->chatId = $chatId;
        $this->voice = $voice;
    }

    /**
     * @return string
     */
    public function getVoice(): string
    {
        return $this->voice;
    }

    /**
     * @param string $photo
     *
     * @return SendVoice
     */
    public function setVoice(string $voice): self
    {
        $this->voice = $voice;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendVoice';
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
            'voice' => $this->voice,
        ];

        $params = array_merge($params, $this->buildJsonAttributes([
            'duration' => $this->duration,
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
