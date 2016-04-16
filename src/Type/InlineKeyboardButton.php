<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * InlineKeyboardButton
 */
class InlineKeyboardButton implements \JsonSerializable
{
    /**
     * Label text on the button.
     *
     * @var string
     */
    protected $text;

    /**
     * HTTP url to be opened when button is pressed.
     *
     * @var string|null
     */
    protected $url;

    /**
     * Data to be sent in a callback query to the bot when button is pressed.
     *
     * @var string|null
     */
    protected $callbackData;

    /**
     * If set, pressing the button will prompt the user to select one of their chats,
     * open that chat and insert the bot‘s username and the specified inline query in
     * the input field. Can be empty, in which case just the bot’s username will be inserted.
     *
     * @var string|null
     */
    protected $switchInlineQuery;


    /**
     * @param string $text
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
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     *
     * @return InlineKeyboardButton
     */
    public function setUrl(string $url = null)
    {
        $this->url = $url;

        if ($url !== null) {
            $this->callbackData = null;
            $this->switchInlineQuery = null;
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSwitchInlineQuery()
    {
        return $this->switchInlineQuery;
    }

    /**
     * @param null|string $switchInlineQuery
     *
     * @return InlineKeyboardButton
     */
    public function setSwitchInlineQuery(string $switchInlineQuery = null)
    {
        $this->switchInlineQuery = $switchInlineQuery;

        if ($switchInlineQuery !== null) {
            $this->callbackData = null;
            $this->url = null;
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCallbackData()
    {
        return $this->callbackData;
    }

    /**
     * @param null|string $callbackData
     *
     * @return InlineKeyboardButton
     */
    public function setCallbackData($callbackData)
    {
        $this->callbackData = $callbackData;

        if ($callbackData !== null) {
            $this->url = null;
            $this->switchInlineQuery = null;
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

        if ($this->url !== null) {
            $result['url'] = $this->url;
        } elseif ($this->callbackData !== null) {
            $result['callback_data'] = $this->callbackData;
        } elseif ($this->switchInlineQuery !== null) {
            $result['switch_inline_query'] = $this->switchInlineQuery;
        } else {
            throw new \LogicException("InlineKeyboardButton serialize error: url or callback_data or switch_inline_query must be set");
        }

        return $result;
    }
}
