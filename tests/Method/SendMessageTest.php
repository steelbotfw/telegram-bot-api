<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Method;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Enum\ParseMode;
use Steelbot\TelegramBotApi\Method\HttpMethod;
use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\Type\Message;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

#[CoversClass(SendMessage::class)]
class SendMessageTest extends TestCase
{
    public function testGetParams()
    {
        $method = new SendMessage(123, "Hello");
        $method->setDisableWebPagePreview(true)
               ->setDisableNotification(true)
               ->setReplyToMessageId(321)
               ->setParseMode(ParseMode::Markdown);

        $params = $method->getParams();

        $this->assertArrayHasKey('disable_web_page_preview', $params);
        $this->assertEquals(1, $params['disable_web_page_preview']);
        $this->assertArrayHasKey('disable_notification', $params);
        $this->assertEquals(1, $params['disable_notification']);
        $this->assertArrayHasKey('reply_to_message_id', $params);
        $this->assertEquals(321, $params['reply_to_message_id']);
        $this->assertArrayHasKey('parse_mode', $params);
        $this->assertEquals('Markdown', $params['parse_mode']);
    }

    #[DataProvider('buildResultDataProvider')]
    public function testBuildResult($data): void
    {
        $method = new SendMessage($data['chat']['id'], $data['text']);

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertEquals($data['text'], $message->text);
    }

    public static function buildResultDataProvider(): array
    {
        return [
            'data1' => [
                [
                    'message_id' => 4757,
                    'from' => [
                        'id' => 987654320,
                        'is_bot' => false,
                        'first_name' => 'Steel Bot',
                        'username' => 'SteelbotBot'
                    ],

                    'chat' => [
                        'id' => 987654321,
                        'first_name' => 'Mister',
                        'last_name' => 'Botman',
                        'username' => 'mrbotman',
                        'type' => 'private'
                    ],

                    'date' => 1456600086,
                    'text' => 'Hello there!'
                ]
            ],
            'data2' => [
                [
                    'message_id' => 4757,
                    'from' => [
                        'id' => 987654320,
                        'is_bot' => false,
                        'first_name' => 'Steel Bot',
                    ],

                    'chat' => [
                        'id' => 987654321,
                        'type' => 'private'
                    ],

                    'date' => 1456600086,
                    'text' => 'Hello there!'
                ]
            ],
        ];
    }

    public function testJsonSerialize_Always_SerializesObject(): void
    {
        $method = new SendMessage(123, "Hello");
        $r = new ReplyKeyboardMarkup([]);
        $r->addKeyboardButton('adawd');
        $method->setReplyMarkup($r);

        $serialized = [
            'text' => "Hello",
            'reply_markup' => [
                'keyboard' => [
                    ['adawd']
                ]
            ]
        ];

        $this->assertSame($serialized, $method->jsonSerialize());
    }

    public function testGetHttpMethod()
    {
        $method = new SendMessage(123, "Hello");

        $this->assertEquals(HttpMethod::POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendMessage(123, "Hello");

        $this->assertEquals('sendMessage', $method->getMethodName());
    }

    public function testGetSetText()
    {
        $method = new SendMessage(123, "Old text");

        $method->setText("New text");

        $this->assertEquals("New text", $method->getText());
    }
}
