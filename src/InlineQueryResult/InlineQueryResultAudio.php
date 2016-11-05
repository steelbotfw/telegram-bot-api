<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait,
    InputMessageContentTrait,
    JsonAttributesBuilderTrait,
    ReplyMarkupTrait
};

class InlineQueryResultAudio extends AbstractInlineQueryResult
{
    use CaptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'audio';

    /**
     * A valid URL for the audio file.
     *
     * @var string
     */
    protected $audioUrl;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $performer;

    /**
     * Audio duration in seconds.
     *
     * @var int|null
     */
    protected $audioDuration;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $audioUrl, string $title)
    {
        parent::__construct($id);
        $this->audioUrl = $audioUrl;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAudioUrl(): string
    {
        return $this->audioUrl;
    }

    /**
     * @param string $audioUrl
     *
     * @return InlineQueryResultAudio
     */
    public function setAudioUrl(string $audioUrl): InlineQueryResultAudio
    {
        $this->audioUrl = $audioUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return InlineQueryResultAudio
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getPerformer(): ?string
    {
        return $this->performer;
    }

    /**
     * @param string $performer
     *
     * @return InlineQueryResultAudio
     */
    public function setPerformer(?string $performer): InlineQueryResultAudio
    {
        $this->performer = $performer;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAudioDuration(): ?int
    {
        return $this->audioDuration;
    }

    /**
     * @param int|null $audioDuration
     *
     * @return InlineQueryResultAudio
     */
    public function setAudioDuration(?int $audioDuration): InlineQueryResultAudio
    {
        $this->audioDuration = $audioDuration;

        return $this;
    }
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'audio_url' => $this->audioUrl,
            'title' => $this->title
        ]);

        $attributes = $this->buildJsonAttributes([
            'performer' => $this->performer,
            'audio_duration' => $this->audioDuration,
            'caption' => $this->caption,
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
