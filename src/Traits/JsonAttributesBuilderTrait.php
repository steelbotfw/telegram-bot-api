<?php

namespace Steelbot\TelegramBotApi\Traits;

trait JsonAttributesBuilderTrait
{
    /**
     * @var string|null
     */
    protected $caption = null;

    /**
     * @param array $map
     *
     * @return array
     */
    protected function buildJsonAttributes(array $map): array
    {
        $result = [];

        foreach ($map as $jsonKey => $value) {
            if ($value !== null) {
                $result[$jsonKey] = $value;
            }
        }

        return $result;
    }
}
