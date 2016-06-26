#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Icicle\{
    Coroutine\Coroutine,
    Loop
};
use Steelbot\TelegramBotApi\{
    Api, Method\AnswerCallbackQuery,
    Method\EditMessageReplyMarkup,
    Method\EditMessageText,
    Method\SendMessage,
    Type\Chat,
    Type\InlineKeyboardButton,
    Type\InlineKeyboardMarkup,
    Type\Update
};


if (!getenv('BOT_TOKEN')) {
    echo "Error: BOT_TOKEN environment variable not found\n";
    printf("Usage:\n  BOT_TOKEN=123:telegram_bot_token ./%s\n", basename(__FILE__));
    exit(-1);
}

class Bot
{
    const STATE_WAITING_MESSAGE = 1;
    const STATE_WAITING_COMMAND = 2;

    /**
     * @var int
     */
    protected $state = self::STATE_WAITING_MESSAGE;

    protected $api;

    /**
     * @var \Steelbot\TelegramBotApi\Type\Message|null
     */
    protected $message;

    /**
     * @var InlineKeyboardMarkup
     */
    protected $inlineKeyboardMarkup;

    public function __construct()
    {
        $this->api = new Api(getenv('BOT_TOKEN'));
    }

    public function coroutine(): \Generator
    {
        $updateId = 1;

        printf("Waiting for updates ...\n");
        while (true) {

            // waiting for updates from telegram server
            /** @var Update[] $updates */
            $updates = yield from $this->api->getUpdates($updateId);

            foreach ($updates as $update) {
                yield from $this->processUpdate($update);
                $updateId = $update->updateId;
            }
        }
    }

    protected function processUpdate(Update $update)
    {
        $updateId = $update->updateId;

        printf("Got update #%d\n", $updateId);

        switch ($this->state)
        {
            case self::STATE_WAITING_MESSAGE:
                yield from $this->stateWaitingMessage($update);
                break;

            case self::STATE_WAITING_COMMAND:
                yield from $this->stateWaitingCommand($update);
                break;
        }
    }

    protected function stateWaitingMessage(Update $update): \Generator
    {
        if (!empty($update->message)) {
            $message = $update->message;

            if (!empty($update->message->text)) {
                printf("  Got message: %s\n", $message->text);

                if (!empty($message->from) && !empty($message->chat)) {
                    switch ($message->chat->type) {
                        case Chat::TYPE_PRIVATE:
                            printf("  Sending answer to a user %s\n", $message->chat->id);
                            $text = "Hello! To edit message, send me one of the following commands:\n".
                                "/text, /markup, /end";
                            $method = new SendMessage($message->chat->id, $text);

                            $this->state = self::STATE_WAITING_COMMAND;
                            $this->message = yield from $this->api->execute($method);

                            break;

                        case Chat::TYPE_GROUP:
                        case Chat::TYPE_SUPERGROUP:
                            printf("  Edit message is available only for private chats\n");
                            break;
                    }
                }
            }
        }

        return null;
    }

    protected function stateWaitingCommand(Update $update): \Generator
    {
        if (!empty($update->message)) {
            $message = $update->message;

            if (!empty($update->message->text)) {
                printf("  Got message: %s\n", $message->text);

                if (!empty($message->from) && !empty($message->chat)) {
                    switch ($message->chat->type) {
                        case Chat::TYPE_PRIVATE:
                            switch ($message->text) {
                                case '/text':
                                    yield from $this->textCommand();
                                    break;

                                case '/markup':
                                    yield from $this->markupCommand();
                                    break;

                                case '/end':
                                    yield from $this->endCommand();
                                    break;
                            }

                            break;
                        case Chat::TYPE_GROUP:
                        case Chat::TYPE_SUPERGROUP:
                            printf("  Edit message is available only for private chats\n");
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
            } elseif ($callbackQuery->data == 'edit') {
                $newText = $this->message->text.' edit-callback';

                $editMethod = new EditMessageText($newText);
                $editMethod->setMessageId($this->message->messageId);
                $editMethod->setChatId($this->message->chat->id);
                $editMethod->setReplyMarkup($this->inlineKeyboardMarkup);
                $this->message = yield from $this->api->execute($editMethod);
            }

            yield from $this->api->execute($method);
        }

        return null;
    }

    protected function textCommand(): \Generator
    {
        $newText = $this->message->text."\n edit-text";

        $method = new EditMessageText($newText);
        $method->setMessageId($this->message->messageId);
        $method->setChatId($this->message->chat->id);
        $this->inlineKeyboardMarkup = null;
        $this->message = yield from $this->api->execute($method);
    }

    protected function markupCommand(): \Generator
    {
        if ($this->inlineKeyboardMarkup === null) {
            $button1 = (new InlineKeyboardButton('Edit inline text'))
                ->setCallbackData('edit');
            $button3 = (new InlineKeyboardButton('Show text'))
                ->setCallbackData('text');
            $button4 = (new InlineKeyboardButton('Show alert'))
                ->setCallbackData('alert');

            $markupData = [
                [$button1],
                [$button3, $button4],
            ];
            $this->inlineKeyboardMarkup = new InlineKeyboardMarkup($markupData);
        } else {
            $this->inlineKeyboardMarkup = null;
        }


        $method = new EditMessageReplyMarkup();
        $method->setMessageId($this->message->messageId);
        $method->setChatId($this->message->chat->id);

        $method->setReplyMarkup($this->inlineKeyboardMarkup);
        $this->message = yield from $this->api->execute($method);
    }

    protected function endCommand(): \Generator
    {
        $this->state = self::STATE_WAITING_MESSAGE;

        $method = new SendMessage($this->message->chat->id, "Edit mode cancelled");
        $this->message = null;
        yield from $this->api->execute($method);
    }

}

$bot = new Bot();
$coroutine = new Coroutine($bot->coroutine());
$coroutine->done(null, function (\Throwable $exception) {
    echo "Exception catched:\n";
    echo "    Code: {$exception->getCode()}\n";
    echo "    Message: {$exception->getMessage()}\n";
    echo "    File: {$exception->getFile()}\n";
    echo "    Line: {$exception->getLine()}\n";
});

Loop\run();

