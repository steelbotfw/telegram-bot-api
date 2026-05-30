<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Method;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Method\HttpMethod;
use Steelbot\TelegramBotApi\Method\SetWebhook;
use Steelbot\TelegramBotApi\Type\Basic\UpdateType;

final class SetWebhookAllParametersTest extends TestCase
{
    public function testConstructor_WithAllParameters_SerializesPayload(): void
    {
        $method = new SetWebhook(
            url: 'https://example.com/webhook',
            certificate: 'attach://certificate',
            ipAddress: '203.0.113.10',
            maxConnections: 42,
            allowedUpdates: [UpdateType::Message, 'callback_query'],
            dropPendingUpdates: true,
            secretToken: 'secret-token_1',
        );

        self::assertSame('setWebhook', $method->getMethodName());
        self::assertSame(HttpMethod::POST, $method->getHttpMethod());
        self::assertSame([], $method->getParams());
        self::assertTrue($method->buildResult(true));
        self::assertSame([
            'url' => 'https://example.com/webhook',
            'certificate' => 'attach://certificate',
            'ip_address' => '203.0.113.10',
            'max_connections' => 42,
            'allowed_updates' => ['message', 'callback_query'],
            'drop_pending_updates' => true,
            'secret_token' => 'secret-token_1',
        ], $method->jsonSerialize());
    }

    public function testSetters_WithNullableParameters_UpdatePayload(): void
    {
        $method = new SetWebhook('https://example.com/webhook');
        $method
            ->setCertificate('attach://certificate')
            ->setIpAddress('203.0.113.10')
            ->setMaxConnections(42)
            ->setAllowedUpdates([UpdateType::Message])
            ->setDropPendingUpdates(false)
            ->setSecretToken('secret-token_1');

        self::assertSame('attach://certificate', $method->getCertificate());
        self::assertSame('203.0.113.10', $method->getIpAddress());
        self::assertSame(42, $method->getMaxConnections());
        self::assertSame([UpdateType::Message], $method->getAllowedUpdates());
        self::assertFalse($method->getDropPendingUpdates());
        self::assertSame('secret-token_1', $method->getSecretToken());
        self::assertSame([
            'url' => 'https://example.com/webhook',
            'certificate' => 'attach://certificate',
            'ip_address' => '203.0.113.10',
            'max_connections' => 42,
            'allowed_updates' => ['message'],
            'drop_pending_updates' => false,
            'secret_token' => 'secret-token_1',
        ], $method->jsonSerialize());

        $method
            ->setCertificate(null)
            ->setIpAddress(null)
            ->setMaxConnections(null)
            ->setAllowedUpdates(null)
            ->setDropPendingUpdates(null)
            ->setSecretToken(null);

        self::assertSame(['url' => 'https://example.com/webhook'], $method->jsonSerialize());
    }
}
