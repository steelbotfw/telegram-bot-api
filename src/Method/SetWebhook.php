<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;
use Steelbot\TelegramBotApi\Type\Basic\UpdateType;
use JsonSerializable;

/**
 * @extends AbstractMethod<bool>
 */
class SetWebhook extends AbstractMethod implements JsonSerializable
{
    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $url;

    /**
     * @todo
     * @var
     */
    protected $certificate;

    /**
     * @var int|null
     */
    protected $maxConnections;

    /**
     * @var UpdateType[]|null
     */
    protected ?array $allowedUpdates;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'setWebhook';
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
        return [];
    }

    /**
     * Build result type from array of data.
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return SetWebhook
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param mixed $certificate
     *
     * @return SetWebhook
     */
    public function setCertificate($certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxConnections(): ?int
    {
        return $this->maxConnections;
    }

    /**
     * @param int|null $maxConnections
     *
     * @return SetWebhook
     */
    public function setMaxConnections(?int $maxConnections): self
    {
        $this->maxConnections = $maxConnections;

        return $this;
    }

    /**
     * @return null|\string[]
     */
    public function getAllowedUpdates(): ?array
    {
        return $this->allowedUpdates;
    }

    /**
     * @param null|UpdateType[] $allowedUpdates
     *
     * @return SetWebhook
     */
    public function setAllowedUpdates(array $allowedUpdates): self
    {
        $this->allowedUpdates = $allowedUpdates;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        $data = [
            'url' => $this->url
        ];

        return array_merge($data, $this->buildJsonAttributes([
            'certificate' => $this->certificate,
            'max_connections' => $this->maxConnections,
            'allowed_updates' => array_map(
                static fn (UpdateType $ut) => $ut->value,
                $this->allowedUpdates ?? []
            )
        ]));
    }
}
