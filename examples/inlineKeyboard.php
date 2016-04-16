#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Icicle\{
    Coroutine\Coroutine,
    Loop
};
use Steelbot\TelegramBotApi\{
    Api, Method\AnswerCallbackQuery, Method\SendMessage, Type\Chat, Type\InlineKeyboardButton, Type\InlineKeyboardMarkup, Type\Update
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

            $button1 = (new InlineKeyboardButton('Go to GitHub'))
                ->setUrl('https://github.com');
            $button2 = (new InlineKeyboardButton('Switch to inline'))
                ->setSwitchInlineQuery("test query");
            $button3 = (new InlineKeyboardButton('Show text'))
                ->setCallbackData('text');
            $button4 = (new InlineKeyboardButton('Show alert'))
                ->setCallbackData('alert');

            $markupData = [
                [ $button1, $button2 ],
                [ $button3, $button4 ],
            ];
            $inlineReplyMarkup = new InlineKeyboardMarkup($markupData);

            if (!empty($message->from) && !empty($message->chat)) {
                switch ($message->chat->type) {
                    case Chat::TYPE_PRIVATE:
                        printf("  Sending answer to a user %s\n", $message->chat->id);
                        $method = new SendMessage($message->chat->id, $message->text);
                        $method->setReplyMarkup($inlineReplyMarkup);

                        return $method;
                        break;
                    case Chat::TYPE_GROUP:
                    case Chat::TYPE_SUPERGROUP:
                        printf("  Inline keyboard is available only for private chats\n");
                        break;
                }
            }
        }
    } elseif (!empty($update->callbackQuery)) {
        $callbackQuery = $update->callbackQuery;

        printf(" CallbackQuery received:\n");
        print_r($callbackQuery);

        $method = new AnswerCallbackQuery($callbackQuery->id);

        if ($callbackQuery->data == 'text') {
            $method->setText("Show text");
        } elseif ($callbackQuery->data == 'alert') {
            $method->setShowAlert(true);
            $method->setText("Show alert");
        }

        return $method;
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
        $updates = yield from $api->getUpdates($updateId);

        foreach ($updates as $update) {
            $method = processUpdate($update);

            if (is_object($method)) {
                yield from $api->execute($method);
            }
            $updateId = $update->updateId;
        }
    }
};

$coroutine = new Coroutine(botCoroutine());
$coroutine->done(null, function (\Throwable $exception) {
    echo "Exception catched:\n";
    echo "    Code: {$exception->getCode()}\n";
    echo "    Message: {$exception->getMessage()}\n";
    echo "    File: {$exception->getFile()}\n";
    echo "    Line: {$exception->getLine()}\n";
});

Loop\run();

