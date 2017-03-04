<?php
namespace Steelbot\TelegramBotApi\Type;

class WebhookInfo
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var bool
     */
    public $hasCustomCertificate;

    /**
     * @var int
     */
    public $pendingUpdateCount;

    /**
     * @var int|null
     */
    public $lastErrorDate;

    /**
     * @var string|null
     */
    public $lastErrorMessage;

    /**
     * @var int|null
     */
    public $maxConnections;

    /**
     * @var string[]|null
     */
    public $allowedUpdates;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->hasCustomCertificate = $data['has_custom_certificate'];
        $this->pendingUpdateCount = $data['pending_update_count'];
        $this->lastErrorDate = $data['last_error_date'] ?? null;
        $this->lastErrorMessage = $data['last_error_message'] ?? null;
        $this->maxConnections = $data['max_connection'] ?? null;
        $this->allowedUpdates = $data['allowed_updates'] ?? null;
    }
}
