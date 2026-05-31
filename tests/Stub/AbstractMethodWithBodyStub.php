<?php

namespace Steelbot\Tests\TelegramBotApi\Stub;

use JsonSerializable;
use Steelbot\TelegramBotApi\Method\AbstractMethod;

abstract class AbstractMethodWithBodyStub extends AbstractMethod implements JsonSerializable
{
}
