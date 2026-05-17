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
     * @template T of object|array|bool|int
     * @param AbstractMethod<T> $method
     * @return T
     *
     * @throws TelegramBotApiException
     */
    public function execute(AbstractMethod $method): object|array|bool|int;

    /**
     * Execute an API method and return raw response body without JSON parsing.
     */
    public function executeRaw(AbstractMethod $method): string;

    /**
     * @return Update[]
     */
    public function getUpdates(?int $lastUpdateId = null, int $limit = 5, int $timeout = 30): array;
}
