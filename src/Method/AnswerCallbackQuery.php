<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;

/**
 * @extends AbstractMethod<bool>
 */
class AnswerCallbackQuery extends AbstractMethod implements JsonSerializable
{
    use JsonAttributesBuilderTrait;

    protected ?string $text = null;

    protected ?bool $showAlert = null;

    protected ?string $url = null;

    protected ?int $cacheTime = null;

    public function __construct(
        protected string $callbackQueryId
    ) {
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
    public function setText(?string $text = null): self
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
    public function setShowAlert(?bool $showAlert = null): self
    {
        $this->showAlert = $showAlert;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     *
     * @return AnswerCallbackQuery
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCacheTime(): ?int
    {
        return $this->cacheTime;
    }

    /**
     * @param int|null $cacheTime
     *
     * @return AnswerCallbackQuery
     */
    public function setCacheTime(?int $cacheTime): self
    {
        $this->cacheTime = $cacheTime;

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
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
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

        $params = array_merge($params, $this->buildJsonAttributes([
            'show_alert' => $this->showAlert,
            'cache_time' => $this->cacheTime
        ]));

        return $params;
    }

    /**
     * Build result type from incoming data.
     *
     * @param bool $result
     *
     * @return bool
     */
    public function buildResult($result): object|array|bool|int
    {
        return $result;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = $this->buildJsonAttributes([
            'text' => $this->text,
            'url' => $this->url
        ]);

        if ($this->text !== null) {
            $result['text'] = $this->text;
        }

        return $result;
    }
}
