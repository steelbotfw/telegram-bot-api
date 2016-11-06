<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    InputMessageContentTrait,
    JsonAttributesBuilderTrait,
    LatLonRequiredTrait,
    ReplyMarkupTrait,
    ThumbUrlOptionalTrait,
    ThumbWidthHeightOptionalTrait,
    TitleRequiredTrait
};

class InlineQueryResultLocation extends AbstractInlineQueryResult
{
    use LatLonRequiredTrait;
    use TitleRequiredTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;
    use ThumbUrlOptionalTrait;
    use ThumbWidthHeightOptionalTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'location';

    /**
     * @param array $data
     */
    public function __construct($id = null, float $latitude, float $longitude, string $title)
    {
        parent::__construct($id);
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'title' => $this->title,
        ]);

        $attributes = $this->buildJsonAttributes([
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent,
            'thumb_url' => $this->thumbUrl,
            'thumb_width' => $this->thumbWidth,
            'thumb_height' => $this->thumbHeight
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
