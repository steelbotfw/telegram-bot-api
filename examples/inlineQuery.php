#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Icicle\Loop;
use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\Type\Chat;
use Steelbot\TelegramBotApi\Type\Update;

if (!getenv('BOT_TOKEN')) {
    echo "Error: BOT_TOKEN environment variable not found\n";
    printf("Usage:\n  BOT_TOKEN=123:telegram_bot_token ./%s\n", basename(__FILE__));
    exit(-1);
}

$generator = function () {
    $api = new Api(getenv('BOT_TOKEN'));

    while (true) {
        // waiting for updates from telegram server
        /** @var Update[] $updates */
        $updates = yield from $api->getUpdates();

        foreach ($updates as $update) {
            if ($update->inlineQuery) {
                $inlineQuery = $update->inlineQuery;

                for ($results=[]; count($results)<5;) {
                    $results[] = new \Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultArticle(
                        null, "IQ title 1", "You entered 1: " . $inlineQuery->query
                    );
                    $results[] = new \Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultArticle(
                        null, "IQ title 2", "You entered 2: " . $inlineQuery->query
                    );
                }

                $method = new \Steelbot\TelegramBotApi\Method\AnswerInlineQuery($inlineQuery->id, $results);

                echo "Answering to #{$inlineQuery->id}\n";
                yield from $api->execute($method);
            }

        }
    }
};

$coroutine = new \Icicle\Coroutine\Coroutine($generator());
$coroutine->done(null, function (\Throwable $exception) {
    echo "Exception catched:\n";
    echo "    Code: {$exception->getCode()}\n";
    echo "    Message: {$exception->getMessage()}\n";
    echo "    File: {$exception->getFile()}\n";
    echo "    Line: {$exception->getLine()}\n";
});

Loop\run();

