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

//forward_from 	User 	Optional. For forwarded messages, sender of the original message
//forward_from_chat 	Chat 	Optional. For messages forwarded from a channel, information about the original channel
//forward_date 	Integer 	Optional. For forwarded messages, date the original message was sent in Unix time
//reply_to_message 	Message 	Optional. For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
//audio 	Audio 	Optional. Message is an audio file, information about the file
//document 	Document 	Optional. Message is a general file, information about the file

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
//voice 	Voice 	Optional. Message is a voice message, information about the file
//caption 	String 	Optional. Caption for the photo or video, 0-200 characters

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


    /**
     * A new member was added to the group, information about them (this member may be the bot itself).
     *
     * @var User|null
     */
    public $newChatParticipant;

    /**
     * A member was removed from the group, information about them (this member may be the bot itself).
     *
     * @var User
     */
    public $leftChatParticipant;

    /**
     * A chat title was changed to this value.
     *
     * @var string|null
     */
    public $newChatTitle;

//new_chat_photo 	Array of PhotoSize 	Optional. A chat photo was change to this value
//delete_chat_photo 	True 	Optional. Service message: the chat photo was deleted
//group_chat_created 	True 	Optional. Service message: the group has been created
//supergroup_chat_created 	True 	Optional. Service message: the supergroup has been created
//channel_chat_created 	True 	Optional. Service message: the channel has been created
//migrate_to_chat_id 	Integer 	Optional. The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value
//migrate_from_chat_id 	Integer 	Optional. The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value
//pinned_message Optional. Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->messageId = $data['message_id'];
        $this->from      = isset($data['from']) ? new User($data['from']) : null;
        $this->chat      = new Chat($data['chat']);
        $this->date      = \DateTimeImmutable::createFromFormat('U', $data['date']);
        $this->text      = isset($data['text']) ? $data['text'] : null;
        $this->photo     = isset($data['photo']) ? array_map(function(array $photoSizeData) {
            return new PhotoSize($photoSizeData);
        }, $data['photo']) : null;
        $this->sticker   = isset($data['sticker']) ? new Sticker($data['sticker']) : null;
        $this->contact   = isset($data['contact']) ? new Contact($data['contact']) : null;
        $this->location  = isset($data['location']) ? new Location($data['location']) : null;
        //$this->newChatParticipant = isset($data['new_chat_participant']) ? new User($data['new_chat_participant']) : null;
        //$this->leftChatParticipant = isset($data['left_chat_participant']) ? new User($data['left_chat_participant']) : null;
        //$this->newChatTitle = $data['new_chat_title'] ?? null;
    }
}
