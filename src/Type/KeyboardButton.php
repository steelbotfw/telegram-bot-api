<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * KeyboardButton
 */
class KeyboardButton implements \JsonSerializable
{
    /**
     * Text of the button. If none of the optional fields are used, it will be sent to the bot
     * as a message when the button is pressed.
     *
     * @var string
     */
    protected $text;

    /**
     * If True, the user's phone number will be sent as a contact when the button is pressed.
     * Available in private chats only.
     *
     * @var bool|null
     */
    protected $requestContact;

    /**
     * If True, the user's current location will be sent when the button is pressed.
     * Available in private chats only.
     *
     * @var bool|null
     */
    protected $requestLocation;

    /**
     * @param array $data
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return KeyboardButton
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getRequestLocation()
    {
        return $this->requestLocation;
    }

    /**
     * @param bool|null $requestLocation
     *
     * @return KeyboardButton
     */
    public function setRequestLocation(bool $requestLocation = null): self
    {
        $this->requestLocation = $requestLocation;

        if ($requestLocation === true) {
            $this->requestContact = null;
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getRequestContact()
    {
        return $this->requestContact;
    }

    /**
     * @param bool|null $requestContact
     *
     * @return KeyboardButton
     */
    public function setRequestContact(bool $requestContact = null): self
    {
        $this->requestContact = $requestContact;

        if ($requestContact === true) {
            $this->requestLocation = null;
        }

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        $result = [
            'text' => $this->text
        ];

        if ($this->requestContact !== null) {
            $result['request_contact'] = $this->requestContact;
        }

        if ($this->requestLocation !== null) {
            $result['request_location'] = $this->requestLocation;
        }

        return $result;
    }
}
