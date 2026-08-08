<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Type\Basic;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Type\Basic\Update;
use Steelbot\TelegramBotApi\Type\Basic\UpdateType;
use Steelbot\TelegramBotApi\Type\ChatMemberUpdated;

final class UpdateTest extends TestCase
{
    public function testItBuildsMyChatMemberUpdate(): void
    {
        $update = new Update([
            'update_id' => 1,
            'my_chat_member' => [
                'chat' => [
                    'id' => -100123,
                    'type' => 'supergroup',
                    'title' => 'ImgyBot chat',
                    'username' => 'imgybot_chat',
                ],
                'from' => [
                    'id' => 42,
                    'is_bot' => false,
                    'first_name' => 'Pavel',
                ],
                'date' => 1_752_000_000,
                'old_chat_member' => [
                    'user' => [
                        'id' => 10,
                        'is_bot' => true,
                        'first_name' => 'ImgyBot',
                    ],
                    'status' => 'left',
                ],
                'new_chat_member' => [
                    'user' => [
                        'id' => 10,
                        'is_bot' => true,
                        'first_name' => 'ImgyBot',
                    ],
                    'status' => 'member',
                ],
            ],
        ]);

        self::assertSame(UpdateType::MyChatMember, $update->getType());
        self::assertInstanceOf(ChatMemberUpdated::class, $update->myChatMember);
        self::assertSame(-100123, $update->myChatMember->chat->id);
        self::assertSame(42, $update->myChatMember->from->id);
        self::assertSame('member', $update->myChatMember->newChatMember->status);
        self::assertEquals(new DateTimeImmutable('@1752000000'), $update->myChatMember->date);
    }
}
