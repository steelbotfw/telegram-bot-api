<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Game
 */
class Game
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var PhotoSize[]
     */
    public $photo;

    /**
     * @var string|null
     */
    public $text;

    /**
     * @var MessageEntity[]|null
     */
    public $textEntities;

    /**
     * @var Animation|null
     */
    public $animation;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->photo = isset($data['photo']) ? PhotoSize::createMultiple($data['photo']) : null;
        $this->text = $data['text'] ?? null;
        $this->textEntities = isset($data['text_entities']) ?
            MessageEntity::createMultiple($data['text_entities']) :
            null;
        $this->animation = isset($data['animation']) ? new Animation($data['animation']) : null;
    }
}
