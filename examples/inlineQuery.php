#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Icicle\Loop;
use Steelbot\TelegramBotApi\{
    Api,
    InlineQueryResult\InlineQueryResultArticle,
    InputMessageContent\InputContactMessageContent,
    InputMessageContent\InputLocationMessageContent,
    InputMessageContent\InputTextMessageContent,
    InputMessageContent\InputVenueMessageContent,
    Type\Update
};

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

                $results[] = new InlineQueryResultArticle(
                    null, "Text result", new InputTextMessageContent("You entered 1: " . $inlineQuery->query)
                );
                $results[] = new InlineQueryResultArticle(
                    null, "Location result", new InputLocationMessageContent(55.757, 37,616)
                );
                $results[] = new InlineQueryResultArticle(
                    null, "Venue result", new InputVenueMessageContent(55.757, 37.616, "Venue title", "Venue address")
                );
                $results[] = new InlineQueryResultArticle(
                    null, "Contact result", new InputContactMessageContent('+0123456789', "First Name")
                );

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

