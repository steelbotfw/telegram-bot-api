<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * MessageEntity
 */
class MessageEntity
{
    const TYPE_MENTION = 'mention';

    const TYPE_HASHTAG = 'hashtag';

    const TYPE_BOT_COMMAND = 'bot_command';

    const TYPE_URL = 'url';

    const TYPE_EMAIL = 'email';

    const TYPE_BOLD = 'bold';

    const TYPE_ITALIC = 'italic';

    const TYPE_CODE = 'code';

    const TYPE_PRE = 'pre';

    const TYPE_TEXT_LINK = 'text_link';

    const TYPE_TEXT_MENTION = 'text_mention';

    /**
     * Type of the entity.
     *
     * @var string
     */
    public $type;

    /**
     * Offset in UTF-16 code units to the start of the entity.
     *
     * @var int
     */
    public $offset;

    /**
     * Length of the entity in UTF-16 code units.
     *
     * @var int
     */
    public $length;

    /**
     * For "text_link" only, url that will be opened after user taps on the text.
     *
     * @var string|null
     */
    public $url;

    /**
     * For "text_mention" only, the mentioned user.
     *
     * @var User|null
     */
    public $user;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->type = $data['type'];
        $this->offset = $data['offset'];
        $this->length = $data['length'];
        $this->url = $data['url'] ?? null;
        $this->user = isset($data['user']) ? new User($data['user']) : null;
    }

    /**
     * @param array $messageEntityArray
     *
     * @return self[]|null
     */
    public static function createMultiple(?array $messageEntityArray): ?array
    {
        if (is_array($messageEntityArray)) {
            return array_map(function (array $messageEntityData) {
                return new self($messageEntityData);
            }, $messageEntityArray);
        }

        return null;
    }
}
