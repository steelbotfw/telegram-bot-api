<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * UserProfilePhotos
 */
class UserProfilePhotos
{
    /**
     * Total number of profile pictures the target user has.
     *
     * @var int
     */
    public $totalCount;

    /**
     * Requested profile pictures (in up to 4 sizes each).
     *
     * @var PhotoSize[][]
     */
    public $photos = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->totalCount = $data['total_count'];
        foreach ($data['photos'] as $photoSizes) {
            $photoSizeArray = [];
            foreach ($photoSizes as $photoSizeData) {
                $photoSizeArray[] = new PhotoSize($photoSizeData);
            }
            $this->photos[] = $photoSizeArray;
        }
    }
}
