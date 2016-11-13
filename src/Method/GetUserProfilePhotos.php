<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Traits\JsonAttributesBuilderTrait, Traits\UserIdRequiredTrait, Type\UserProfilePhotos
};

class GetUserProfilePhotos extends AbstractMethod
{
    use UserIdRequiredTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var int|null
     */
    protected $offset;

    /**
     * @var int|null
     */
    protected $limit;

    /**
     * GetUserProfilePhotos constructor.
     *
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     *
     * @return $this
     */
    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function getMethodName(): string
    {
        return 'getUserProfilePhotos';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_GET;
    }

    public function getParams(): array
    {
        $params = [
            'user_id' => $this->userId
        ];

        $params = array_merge($params, $this->buildJsonAttributes([
            'offset' => $this->offset,
            'limit' => $this->limit
        ]));

        return $params;
    }

    /**
     * @param array $result
     *
     * @return UserProfilePhotos[]
     */
    public function buildResult($photos)
    {
        $result = [];

        foreach ($photos as $photoData) {
            $result[] = new UserProfilePhotos($photoData);
        }

        return $result;
    }
}
