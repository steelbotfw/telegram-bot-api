<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
}