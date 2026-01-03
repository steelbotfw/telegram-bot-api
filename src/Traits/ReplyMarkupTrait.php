<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Traits;

use Steelbot\TelegramBotApi\Type\ReplyMarkupInterface;

trait ReplyMarkupTrait
{
    protected ?ReplyMarkupInterface $replyMarkup = null;

    public function getReplyMarkup(): ?ReplyMarkupInterface
    {
        return $this->replyMarkup;
    }

    public function setReplyMarkup(?ReplyMarkupInterface $replyMarkup = null): static
    {
        $this->replyMarkup = $replyMarkup;

        return $this;
    }
}
