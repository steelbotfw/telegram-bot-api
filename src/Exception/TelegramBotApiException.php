<?php

namespace Steelbot\TelegramBotApi\Exception;

use Steelbot\TelegramBotApi\Type\ResponseParameters;

class TelegramBotApiException extends \Exception
{
    /**
     * @var ResponseParameters|null
     */
    protected $parameters;

    /**
     * @return null|ResponseParameters
     */
    public function getParameters(): ?ResponseParameters
    {
        return $this->parameters;
    }

    /**
     * @param null|ResponseParameters $parameters
     *
     * @return TelegramBotApiException
     */
    public function setParameters(?ResponseParameters $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }
}
