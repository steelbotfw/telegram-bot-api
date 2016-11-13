<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    Traits\CaptionTrait,
    Traits\TitleRequiredTrait,
    Traits\InputMessageContentTrait,
    Traits\JsonAttributesBuilderTrait,
    Traits\ReplyMarkupTrait
};

class InlineQueryResultVoice extends AbstractInlineQueryResult
{
    use TitleRequiredTrait;
    use CaptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'voice';

    /**
     * @var string
     */
    protected $voiceUrl;

    /**
     * @var int|null
     */
    protected $voiceDuration;

    /**
     * @param $id
     */
    public function __construct($id, string $voiceUrl, string $title)
    {
        parent::__construct($id);

        $this->voiceUrl = $voiceUrl;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getVoiceUrl(): string
    {
        return $this->voiceUrl;
    }

    /**
     * @param string $voiceUrl
     *
     * @return $this
     */
    public function setVoiceUrl(string $voiceUrl): self
    {
        $this->voiceUrl = $voiceUrl;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVoiceDuration(): ?int
    {
        return $this->voiceDuration;
    }

    /**
     * @param int|null $voiceDuration
     *
     * @return $this
     */
    public function setVoiceDuration(?int $voiceDuration): self
    {
        $this->voiceDuration = $voiceDuration;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'voice_url' => $this->voiceUrl,
            'title' => $this->title,
        ]);

        $attributes = $this->buildJsonAttributes([
            'caption' => $this->caption,
            'voice_duration' => $this->voiceDuration,
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent,
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
