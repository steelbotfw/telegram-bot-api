<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

class SendChatAction extends AbstractMethod
{
    const ACTION_TYPING = 'typing';
    const ACTION_UPLOAD_PHOTO = 'upload_photo';
    const ACTION_RECORD_VIDEO = 'record_video';
    const ACTION_UPLOAD_VIDEO = 'upload_video';
    const ACTION_RECORD_AUDIO = 'record_audio';
    const ACTION_UPLOAD_AUDIO = 'upload_audio';
    const ACTION_UPLOAD_DOCUMENT = 'upload_document';
    const ACTION_FIND_LOCATION = 'find_location';

    use ChatIdRequiredTrait;

    /**
     * @var string
     */
    protected $action;

    public function __construct($chatId, string $action)
    {
        $this->chatId = $chatId;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return SendChatAction
     */
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendChatAction';
    }

    /**
     * HTTP method
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
        return [
            'chat_id' => $this->chatId,
            'action' => $this->action
        ];
    }

    /**
     * Build result type from array of data.
     *
     * @param bool $result
     *
     * @return object
     */
    public function buildResult($result)
    {
        return $result;
    }
}
