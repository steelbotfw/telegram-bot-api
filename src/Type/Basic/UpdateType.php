<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type\Basic;

enum UpdateType: string
{
    case Message = 'message';
    case EditedMessage = 'edited_message';
    case ChannelPost = 'channel_post';
    case EditedChannelPost = 'edited_channel_post';
    case MessageReaction = 'message_reaction';
    case InlineQuery = 'inline_query';
    case ChosenInlineResult = 'chosen_inline_result';
    case CallbackQuery = 'callback_query';
}