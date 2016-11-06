<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    InputMessageContentTrait,
    JsonAttributesBuilderTrait,
    ReplyMarkupTrait,
    ThumbUrlOptionalTrait,
    ThumbWidthHeightOptionalTrait
};

class InlineQueryResultContact extends AbstractInlineQueryResult
{
    use ReplyMarkupTrait;
    use InputMessageContentTrait;
    use ThumbUrlOptionalTrait;
    use ThumbWidthHeightOptionalTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'contact';

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string|null
     */
    protected $lastName;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $phoneNumber, string $firstName)
    {
        parent::__construct($id);
        $this->phoneNumber = $phoneNumber;
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return InlineQueryResultContact
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return InlineQueryResultContact
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     *
     * @return InlineQueryResultContact
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'phone_number' => $this->phoneNumber,
            'first_name' => $this->firstName,
        ]);

        $attributes = $this->buildJsonAttributes([
            'last_name' => $this->lastName,
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
