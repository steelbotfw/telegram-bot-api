<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Enum;

enum ParseMode: string
{
    case MarkdownV2 = 'MarkdownV2';
    case HTML = 'HTML';
    case Markdown = 'Markdown';
}