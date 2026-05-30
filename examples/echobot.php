#!/usr/bin/env php
<?php

declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\Type\Chat;

if (!getenv('BOT_TOKEN')) {
    echo "Error: BOT_TOKEN environment variable not found\n";
    printf("Usage:\n  BOT_TOKEN=123:telegram_bot_token ./%s\n", basename(__FILE__));
    exit(-1);
}


$api = new Api(getenv('BOT_TOKEN'), \Amp\Http\Client\HttpClientBuilder::buildDefault());

while (true) {

    // waiting for updates from telegram server
    $updates = $api->getUpdates();

    foreach ($updates as $update) {
        $updateId = $update->updateId;

        printf("Got update #%d\n", $updateId);

        if (!empty($update->message)) {
            if (empty($update->message->text)) {
                printf("  Message text is empty\n");

            } else {
                $message = $update->message;

                printf("  Got message: %s\n", $message->text);
                print_r($message);

                if (!empty($message->from) && !empty($message->chat)) {
                    switch ($message->chat->type) {
                        case Chat::TYPE_PRIVATE:
                            printf("  Sending answer to a user %s\n", $message->chat->id);
                            $method = (new SendMessage($message->chat->id, $message->text));
                            print_r($method);
                            break;
                        case Chat::TYPE_GROUP:
                        case Chat::TYPE_SUPERGROUP:
                            printf("  Sending answer to a chat %s\n", $message->chat->id);
                            $method = (new SendMessage($message->chat->id, $message->text))
                                ->setReplyToMessageId($message->messageId);
                            break;
                    }

                    $result = $api->execute($method);
                    print_r($result);

                }
            }
        }
    }
}
