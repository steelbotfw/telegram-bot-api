<?php
declare(strict_types=1);

namespace Steelbot\TelegramBotApi;


use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Type\Basic\Update;

/**
 * Telegram bot API
 *
 * @see https://core.telegram.org/bots/api#available-methods
 */
interface TelegramBotApiInterface
{
    /**
     * Execute an API method.
     *
     * @param AbstractMethod $method
     *
     * @throws TelegramBotApiException
     */
    public function execute(AbstractMethod $method): object|array;

    /**
     * @return Update[]
     */
    public function getUpdates(?int $lastUpdateId = null, int $limit = 5, int $timeout = 30): array;
}