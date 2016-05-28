<?php

namespace Steelbot\TelegramBotApi\Type;

class Message
{
    /**
     * Unique message identifier.
     *
     * @var integer
     */
    public $messageId;

    /**
     * Sender, can be empty for messages sent to channels.
     *
     * @var User|null
     */
    public $from;

    /**
     * Date the message was sent in Unix time.
     *
     * @var \DateTimeImmutable
     */
    public $date;

    /**
     * Conversation the message belongs to.
     *
     * @var Chat
     */
    public $chat;

    /**
     * For text messages, the actual UTF-8 text of the message, 0-4096 characters.
     *
     * @var string|null
     */
    public $text;

    /**
     * For forwarded messages, sender of the original message.
     *
     * @var User|null
     */
    public $forwardFrom;

    /**
     * For messages forwarded from a channel, information about the original channel.
     *
     * @var Chat|null
     */
    public $forwardFromChat;

    /**
     * For forwarded messages, date the original message was sent in Unix time.
     *
     * @var \DateTimeImmutable|null
     */
    public $forwardDate;

    /**
     * For replies, the original message. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it itself is a reply.
     *
     * @var Message|null
     */
    public $replyToMessage;

    /**
     * Date the message was last edited in Unix time.
     *
     * @var \DateTimeImmutable|null
     */
    public $editDate;

    /**
     * For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text.
     *
     * @var MessageEntity[]|null
     */
    public $entities;

    /**
     * Message is an audio file, information about the file.
     *
     * @var Audio|null
     */
    public $audio;

    /**
     * Message is a general file, information about the file.
     *
     * @var Document|null
     */
    public $document;

    /**
     * Message is a photo, available sizes of the photo.
     *
     * @var PhotoSize[]|null
     */
    public $photo;

    /**
     * Message is a sticker, information about the sticker.
     *
     * @var Sticker|null
     */
    public $sticker;

//video 	Video 	Optional. Message is a video, information about the video
    /**
     * Message is a voice message, information about the file.
     *
     * @var Voice|null
     */
    public $voice;

    /**
     * Caption for the photo or video, 0-200 characters.
     *
     * @var string|null
     */
    public $caption;

    /**
     * Optional. Message is a shared contact, information about the contact
     *
     * @var Contact|null
     */
    public $contact;

    /**
     * Message is a shared location, information about the location.
     *
     * @var Location|null
     */
    public $location;

//venue 	Venue 	Optional. Message is a venue, information about the venue

    /**
     * A new member was added to the group, information about them (this member may be the bot itself).
     *
     * @var User|null
     */
    public $newChatMember;

    /**
     * A member was removed from the group, information about them (this member may be the bot itself).
     *
     * @var User
     */
    public $leftChatMember;

    /**
     * A chat title was changed to this value.
     *
     * @var string|null
     */
    public $newChatTitle;

    /**
     * A chat photo was change to this value.
     *
     * @var PhotoSize[]|null
     */
    public $newChatPhoto;

    /**
     * Service message: the chat photo was deleted.
     *
     * @var bool|null
     */
    public $deleteChatPhoto;

    /**
     * Service message: the group has been created.
     *
     * @var bool|null
     */
    public $groupChatCreated;

    /**
     * Service message: the supergroup has been created.
     *
     * @var bool|null
     */
    public $supergroupChatCreated;

    /**
     * Service message: the channel has been created.
     *
     * @var bool|null
     */
    public $channelChatCreated;

    /**
     * The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value.
     *
     * @var int|null
     */
    public $migrateToChatId;

    /**
     * The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value.
     *
     * @var int|null
     */
    public $migrateFromChatId;

    /**
     * Specified message was pinned. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it is itself a reply.
     *
     * @var Message|null
     */
    public $pinnedMessage;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->messageId = $data['message_id'];
        $this->from      = isset($data['from']) ? new User($data['from']) : null;
        $this->chat      = new Chat($data['chat']);
        $this->date      = \DateTimeImmutable::createFromFormat('U', $data['date']);
        $this->text      = $data['text'] ?? null;
        $this->forwardFrom = isset($data['forward_from']) ? new User($data['forward_from']) : null;
        $this->forwardFromChat = isset($data['forward_from_chat']) ? new Chat($data['forward_from_chat']) : null;
        $this->forwardDate = isset($data['forward_date']) ? \DateTimeImmutable::createFromFormat('U', $data['forward_date']) : null;
        $this->replyToMessage = isset($data['reply_to_message']) ? new Message($data['reply_to_message']) : null;
        $this->editDate = isset($data['edit_date']) ? \DateTimeImmutable::createFromFormat('U', $data['edit_date']) : null;
        $this->entities = isset($data['entities']) ? array_map(function(array $entityData) {
            return new MessageEntity($entityData);
        }, $data['entities']) : null;
        $this->audio     = isset($data['audio']) ? new Audio($data['audio']) : null;
        $this->document  = isset($data['document']) ? new Document($data['document']) : null;
        $this->photo     = isset($data['photo']) ? array_map(function(array $photoSizeData) {
            return new PhotoSize($photoSizeData);
        }, $data['photo']) : null;
        $this->sticker   = isset($data['sticker']) ? new Sticker($data['sticker']) : null;
        $this->voice     = isset($data['voice']) ? new Voice($data['voice']) : null;
        $this->caption = $data['caption'] ?? null;
        $this->contact   = isset($data['contact']) ? new Contact($data['contact']) : null;
        $this->location  = isset($data['location']) ? new Location($data['location']) : null;
        $this->newChatMember = isset($data['new_chat_member']) ? new User($data['new_chat_member']) : null;
        $this->leftChatMember = isset($data['left_chat_member']) ? new User($data['left_chat_member']) : null;
        $this->newChatTitle = $data['new_chat_title'] ?? null;
        $this->newChatPhoto = isset($data['new_chat_photo']) ? array_map(function(array $photoSizeData) {
            return new PhotoSize($photoSizeData);
        }, $data['new_chat_photo']) : null;
        $this->deleteChatPhoto = isset($data['delete_chat_photo']) ? true : null;
        $this->groupChatCreated = isset($data['group_chat_created']) ? true : null;
        $this->supergroupChatCreated = isset($data['super_group_chat_created']) ? true : null;
        $this->channelChatCreated = isset($data['channel_chat_created']) ? true : null;
        $this->migrateToChatId = $data['migrate_to_chat_id'] ?? null;
        $this->migrateFromChatId = $data['migrate_from_chat_id'] ?? null;
        $this->pinnedMessage = isset($data['pinned_message']) ? new Message($data['pinned_message']) : null;
    }
}
