<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;
use Steelbot\TelegramBotApi\Type\Basic\UpdateType;

/**
 * @extends AbstractMethod<bool>
 */
class SetWebhook extends AbstractMethod implements JsonSerializable
{
    use JsonAttributesBuilderTrait;

    /**
     * @param list<UpdateType|string>|null $allowedUpdates
     */
    public function __construct(
        protected string $url,
        protected mixed $certificate = null,
        protected ?string $ipAddress = null,
        protected ?int $maxConnections = null,
        protected ?array $allowedUpdates = null,
        protected ?bool $dropPendingUpdates = null,
        protected ?string $secretToken = null,
    ) {
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

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

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
     * @return list<UpdateType|string>|null
     */
    public function getAllowedUpdates(): ?array
    {
        return $this->allowedUpdates;
    }

    /**
     * @param list<UpdateType|string>|null $allowedUpdates
     *
     * @return SetWebhook
     */
    public function setAllowedUpdates(?array $allowedUpdates): self
    {
        $this->allowedUpdates = $allowedUpdates;

        return $this;
    }

    public function getDropPendingUpdates(): ?bool
    {
        return $this->dropPendingUpdates;
    }

    public function setDropPendingUpdates(?bool $dropPendingUpdates): self
    {
        $this->dropPendingUpdates = $dropPendingUpdates;

        return $this;
    }

    public function getSecretToken(): ?string
    {
        return $this->secretToken;
    }

    public function setSecretToken(?string $secretToken): self
    {
        $this->secretToken = $secretToken;

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
            'ip_address' => $this->ipAddress,
            'max_connections' => $this->maxConnections,
            'allowed_updates' => $this->buildAllowedUpdates(),
            'drop_pending_updates' => $this->dropPendingUpdates,
            'secret_token' => $this->secretToken,
        ]));
    }

    /**
     * @return list<string>|null
     */
    private function buildAllowedUpdates(): ?array
    {
        if ($this->allowedUpdates === null) {
            return null;
        }

        return array_map(
            static fn (UpdateType|string $updateType): string => $updateType instanceof UpdateType
                ? $updateType->value
                : $updateType,
            $this->allowedUpdates,
        );
    }
}
