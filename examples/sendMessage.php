#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Steelbot\TelegramBotApi\Api;
use Icicle\Loop;

const TELEGRAM_BOT_TOKEN = '123456789:telegramBotToken';

$generator = function () {
    $api = new Api(TELEGRAM_BOT_TOKEN);

    $method = new \Steelbot\TelegramBotApi\Method\SendMessage('104442434', "Hello there!");
    $message = yield from $api->send($method);

    echo "Message was sent:\n";
    print_r($message);
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


