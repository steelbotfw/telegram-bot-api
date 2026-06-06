#!/usr/bin/env php
<?php

declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use Amp\Loop;
use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\Type\Chat;
use Steelbot\TelegramBotApi\Type\Update;

if (!getenv('BOT_TOKEN')) {
    echo "Error: BOT_TOKEN environment variable not found\n";
    printf("Usage:\n  BOT_TOKEN=123:telegram_bot_token ./%s\n", basename(__FILE__));
    exit(-1);
}

try {
    Loop::run(static function () {
        $api = new Api(getenv('BOT_TOKEN'));

        $updateId = 1;

        while (true) {
            // waiting for updates from telegram server
            /** @var Update[] $updates */
            $updates = yield $api->getUpdates($updateId);

            foreach ($updates as $update) {
                $updateId = $update->updateId;

                printf("Got update #%d\n", $updateId);

                if (!empty($update->message)) {
                    if (empty($update->message->text)) {
                        printf("  Message text is empty\n");

                    } else {
                        $message = $update->message;
                        $method = null;

                        printf("  Got message: %s\n", $message->text);

                        if (!empty($message->from) && !empty($message->chat)) {
                            switch ($message->chat->type) {
                                case Chat::TYPE_PRIVATE:
                                    printf("  Sending answer to a user %s\n", $message->chat->id);
                                    $method = new SendMessage($message->chat->id, $message->text);
                                    break;
                                case Chat::TYPE_GROUP:
                                case Chat::TYPE_SUPERGROUP:
                                    printf("  Sending answer to a chat %s\n", $message->chat->id);
                                    $method = (new SendMessage($message->chat->id, $message->text))
                                        ->setReplyToMessageId($message->messageId);
                                    break;
                            }

                            if ($method !== null) {
                                yield $api->execute($method);
                            }

                        }
                    }
                }
            }
        }
    });
} catch (\Throwable $exception) {
    echo "Exception caught:\n";
    echo "    Code: {$exception->getCode()}\n";
    echo "    Message: {$exception->getMessage()}\n";
    echo "    File: {$exception->getFile()}\n";
    echo "    Line: {$exception->getLine()}\n";
}
