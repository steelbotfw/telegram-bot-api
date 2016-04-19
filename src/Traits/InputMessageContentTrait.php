<?php

namespace Steelbot\TelegramBotApi\Traits;

use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

trait InputMessageContentTrait
{
    /**
     * Content of the message to be sent instead of the original content.
     *
     * @var InputMessageContentInterface
     */
    protected $inputMessageContent;

    /**
     * @return InputMessageContentInterface|null
     */
    public function getInputMessageContent()
    {
        return $this->inputMessageContent;
    }

    /**
     * @param InputMessageContentInterface|null $inputMessageContent
     *
     * @return self
     */
    public function setInputMessageContent(InputMessageContentInterface $inputMessageContent = null)
    {
        $this->inputMessageContent = $inputMessageContent;

        return $this;
    }

}
