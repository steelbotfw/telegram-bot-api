#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Amp\Loop;
use Steelbot\TelegramBotApi\{
    Api,
    Method\SendMessage,
    Type\Chat,
    Type\Update,
    Type\ReplyKeyboardMarkup,
    Type\ReplyKeyboardRemove,
    Type\KeyboardButton
};


if (!getenv('BOT_TOKEN')) {
    echo "Error: BOT_TOKEN environment variable not found\n";
    printf("Usage:\n  BOT_TOKEN=123:telegram_bot_token ./%s\n", basename(__FILE__));
    exit(-1);
}

function processUpdate(Update $update)
{
    $updateId = $update->updateId;

    printf("Got update #%d\n", $updateId);

    if (!empty($update->message)) {
        $message = $update->message;

        if (!empty($update->message->text)) {
            printf("  Got message: %s\n", $message->text);

            $replyMarkup = (new ReplyKeyboardMarkup([['Buttons', 'are', 'strings']]))
                ->addKeyboardRow()
                ->addKeyboardButton(new KeyboardButton('Object button 1'))
                ->addKeyboardButton(new KeyboardButton('Object button 2'))
                ->addKeyboardRow(
                    [
                        (new KeyboardButton('Request contact'))->setRequestContact(true)
                    ]
                )
                ->addKeyboardRow(
                    [
                        (new KeyboardButton('Request location'))->setRequestLocation(true)
                    ]
                );
            $replyMarkup
                ->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true);

            if (!empty($message->from) && !empty($message->chat)) {
                switch ($message->chat->type) {
                    case Chat::TYPE_PRIVATE:
                        printf("  Sending answer to a user %s\n", $message->chat->id);
                        $method = new SendMessage($message->chat->id, $message->text);
                        $method->setReplyMarkup($replyMarkup);

                        return $method;
                    case Chat::TYPE_GROUP:
                    case Chat::TYPE_SUPERGROUP:
                        printf("  Sending answer to a chat %s\n", $message->chat->id);
                        $method = new SendMessage($message->chat->id, $message->text);
                        $method->setReplyToMessageId($message->messageId);
                        $replyMarkup->setSelective(true);
                        $method->setReplyMarkup($replyMarkup);

                        return $method;
                }
            }
        } elseif (!empty($message->contact)) {
            printf(" Contact received:");
            $dump = print_r($message->contact, true);
            echo $dump;

            $method = new SendMessage($message->chat->id, "Contact received:\n$dump");
            $method->setReplyMarkup(new ReplyKeyboardRemove());

            return $method;
        } elseif (!empty($message->location)) {
            printf(" Location received:");
            $dump = print_r($message->location, true);
            echo $dump;

            $method = new SendMessage($message->chat->id, "Location received:\n$dump");
            $method->setReplyMarkup(new ReplyKeyboardRemove());

            return $method;
        }
    }

    return null;
}

/**
 * @return Generator
 * @throws \Steelbot\TelegramBotApi\Exception\TelegramBotApiException
 */
function botCoroutine(): \Generator
{
    $api = new Api(getenv('BOT_TOKEN'));

    $updateId = 1;

    printf("Waiting for updates ...\n");
    while (true) {

        // waiting for updates from telegram server
        /** @var Update[] $updates */
        $updates = yield $api->getUpdates($updateId);

        foreach ($updates as $update) {
            $method = processUpdate($update);

            if (is_object($method)) {
                yield $api->execute($method);
            }
            $updateId = $update->updateId;
        }
    }
}

try {
    Loop::run(static function () {
        yield from botCoroutine();
    });
} catch (\Throwable $exception) {
    echo "Exception caught:\n";
    echo "    Code: {$exception->getCode()}\n";
    echo "    Message: {$exception->getMessage()}\n";
    echo "    File: {$exception->getFile()}\n";
    echo "    Line: {$exception->getLine()}\n";
}
