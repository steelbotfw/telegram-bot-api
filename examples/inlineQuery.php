#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Amp\Loop;
use Steelbot\TelegramBotApi\{
    Api,
    InlineQueryResult\InlineQueryResultArticle,
    InputMessageContent\InputContactMessageContent,
    InputMessageContent\InputLocationMessageContent,
    InputMessageContent\InputTextMessageContent,
    InputMessageContent\InputVenueMessageContent,
    Method\AnswerInlineQuery,
    Type\Update
};

if (!getenv('BOT_TOKEN')) {
    echo "Error: BOT_TOKEN environment variable not found\n";
    printf("Usage:\n  BOT_TOKEN=123:telegram_bot_token ./%s\n", basename(__FILE__));
    exit(-1);
}

try {
    Loop::run(static function () {
        $api = new Api(getenv('BOT_TOKEN'));

        while (true) {
            // waiting for updates from telegram server
            /** @var Update[] $updates */
            $updates = yield $api->getUpdates();

            foreach ($updates as $update) {
                if ($update->inlineQuery) {
                    $inlineQuery = $update->inlineQuery;
                    $results = [
                        new InlineQueryResultArticle(
                            null,
                            "Text result",
                            new InputTextMessageContent("You entered 1: " . $inlineQuery->query)
                        ),
                        new InlineQueryResultArticle(
                            null,
                            "Location result",
                            new InputLocationMessageContent(55.757, 37.616)
                        ),
                        new InlineQueryResultArticle(
                            null,
                            "Venue result",
                            new InputVenueMessageContent(55.757, 37.616, "Venue title", "Venue address")
                        ),
                        new InlineQueryResultArticle(
                            null,
                            "Contact result",
                            new InputContactMessageContent('+0123456789', "First Name")
                        ),
                    ];

                    $method = new AnswerInlineQuery($inlineQuery->id, $results);

                    echo "Answering to #{$inlineQuery->id}\n";
                    yield $api->execute($method);
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
