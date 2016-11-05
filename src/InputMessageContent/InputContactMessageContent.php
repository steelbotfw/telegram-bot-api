<?php

namespace Steelbot\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InputContactMessageContent implements InputMessageContentInterface
{
    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string|null
     */
    protected $lastName;

    /**
     * InputContactMessageContent constructor.
     *
     * @param string $phoneNumber
     * @param string $firstName
     */
    public function __construct(string $phoneNumber, string $firstName)
    {
        $this->phoneNumber = $phoneNumber;
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return InputContactMessageContent
     */
    public function setPhoneNumber(string $phoneNumber): InputContactMessageContent
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return InputContactMessageContent
     */
    public function setFirstName(string $firstName): InputContactMessageContent
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     *
     * @return InputContactMessageContent
     */
    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = [
            'phone_number' => $this->phoneNumber,
            'first_name' => $this->firstName
        ];

        if ($this->lastName !== null) {
            $result['last_name'] = $this->lastName;
        }

        return $result;
    }
}
