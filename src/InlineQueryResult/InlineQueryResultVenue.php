<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    Traits\LatLonRequiredTrait,
    Traits\ThumbUrlOptionalTrait,
    Traits\ThumbWidthHeightOptionalTrait,
    Traits\TitleRequiredTrait,
    Traits\InputMessageContentTrait,
    Traits\JsonAttributesBuilderTrait,
    Traits\ReplyMarkupTrait
};

class InlineQueryResultVenue extends AbstractInlineQueryResult
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
    protected $type = 'venue';

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $foursquareId;

    /**
     * @param $id
     */
    public function __construct($id, string $latitude, string $longitude, string $title, string $address)
    {
        parent::__construct($id);

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
     * @param string|null $foursquareId
     *
     * @return $this
     */
    public function setFoursquareId(?string $foursquareId): self
    {
        $this->foursquareId = $foursquareId;

        return $this;
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
            'address' => $this->address
        ]);

        $attributes = $this->buildJsonAttributes([
            'foursquare_id' => $this->foursquareId,
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
