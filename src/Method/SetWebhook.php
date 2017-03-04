<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;

class SetWebhook extends AbstractMethod implements \JsonSerializable
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
     * @var string[]|null
     */
    protected $allowedUpdates;

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
        return [];
    }

    /**
     * Build result type from array of data.
     *
     * @param bool $result
     *
     * @return bool
     */
    public function buildResult($result)
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
     * @param null|\string[] $allowedUpdates
     *
     * @return SetWebhook
     */
    public function setAllowedUpdates($allowedUpdates): self
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
    public function jsonSerialize()
    {
        $data = [
            'url' => $this->url
        ];

        $data = array_merge($data, $this->buildJsonAttributes([
            'certificate' => $this->certificate,
            'max_connections' => $this->maxConnections,
            'allowed_updated' => $this->allowedUpdates
        ]));

        return $data;
    }
}
