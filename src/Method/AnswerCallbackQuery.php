<?php

namespace Steelbot\TelegramBotApi\Method;

class AnswerCallbackQuery extends AbstractMethod implements \JsonSerializable
{
    /**
     * Unique identifier for the query to be answered.
     *
     * @var string
     */
    protected $callbackQueryId;

    /**
     * Text of the notification. If not specified, nothing will be shown to the user.
     *
     * @var string|null
     */
    protected $text;

    /**
     * If true, an alert will be shown by the client instead of a notification at the
     * top of the chat screen. Defaults to false.
     *
     * @var boolean|null
     */
    protected $showAlert;


    public function __construct(string $callbackQueryId)
    {
        $this->callbackQueryId = $callbackQueryId;
    }

    /**
     * @return string
     */
    public function getCallbackQueryId(): string
    {
        return $this->callbackQueryId;
    }

    /**
     * @param string $callbackQueryId
     */
    public function setCallbackQueryId(string $callbackQueryId): self
    {
        $this->callbackQueryId = $callbackQueryId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param null|string $text
     */
    public function setText(string $text = null): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShowAlert()
    {
        return $this->showAlert;
    }

    /**
     * @param bool|null $showAlert
     */
    public function setShowAlert(bool $showAlert = null): self
    {
        $this->showAlert = $showAlert;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'answerCallbackQuery';
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
            'callback_query_id' => $this->callbackQueryId,
        ];

        if ($this->showAlert!== null) {
            $params['show_alert'] = (int)$this->showAlert;
        }

        return $params;
    }

    /**
     * Build result type from incoming data.
     *
     * @param bool $result
     *
     * @return bool
     */
    public function buildResult($result): bool
    {
        return $result;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = [];

        if ($this->text !== null) {
            $result['text'] = $this->text;
        }

        return $result;
    }
}
