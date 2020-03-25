<?php

namespace AurimasNiekis\PushoverClient;

use DateTimeInterface;
use Http\Message\MultipartStream\MultipartStreamBuilder;

/**
 * @package AurimasNiekis\PushoverClient
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Message
{
    public const SOUND_PUSHOVER      = 'pushover';
    public const SOUND_BIKE          = 'bike';
    public const SOUND_BUGLE         = 'bugle';
    public const SOUND_CASH_REGISTER = 'cashregister';
    public const SOUND_CLASSICAL     = 'classical';
    public const SOUND_COSMIC        = 'cosmic';
    public const SOUND_FALLING       = 'falling';
    public const SOUND_GAME_LAN      = 'gamelan';
    public const SOUND_INCOMING      = 'incoming';
    public const SOUND_INTERMISSION  = 'intermission';
    public const SOUND_MAGIC         = 'magic';
    public const SOUND_MECHANICAL    = 'mechanical';
    public const SOUND_PIANO_BAR     = 'pianobar';
    public const SOUND_SIREN         = 'siren';
    public const SOUND_SPACE_ALARM   = 'spacealarm';
    public const SOUND_TUGBOAT       = 'tugboat';
    public const SOUND_ALIEN         = 'alien';
    public const SOUND_CLIMB         = 'climb';
    public const SOUND_PERSISTENT    = 'persistent';
    public const SOUND_ECHO          = 'echo';
    public const SOUND_UP_DOWN       = 'updown';
    public const SOUND_NONE          = 'none';

    public const PRIORITY_LOWEST    = -2;
    public const PRIORITY_LOW       = -1;
    public const PRIORITY_NORMAL    = 0;
    public const PRIORITY_HIGH      = 1;
    public const PRIORITY_EMERGENCY = 1;

    private ?string            $appToken;
    private ?string            $userToken;
    private string             $message;
    private ?string            $attachment;
    private ?array             $device;
    private ?string            $title;
    private ?string            $url;
    private ?string            $urlTitle;
    private ?int               $priority;
    private ?string            $sound;
    private ?DateTimeInterface $timestamp;

    public function __construct(string $message, string $userToken = null, string $appToken = null)
    {
        $this->appToken  = $appToken;
        $this->userToken = $userToken;
        $this->message   = $message;

        $this->attachment = null;
        $this->device     = null;
        $this->title      = null;
        $this->url        = null;
        $this->urlTitle   = null;
        $this->priority   = null;
        $this->sound      = null;
        $this->timestamp  = null;
    }

    /**
     * @return string|null
     */
    public function getAppToken(): ?string
    {
        return $this->appToken;
    }

    /**
     * @param string|null $appToken
     *
     * @return Message
     */
    public function setAppToken(?string $appToken): self
    {
        $this->appToken = $appToken;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserToken(): ?string
    {
        return $this->userToken;
    }

    /**
     * @param string|null $userToken
     *
     * @return Message
     */
    public function setUserToken(?string $userToken): self
    {
        $this->userToken = $userToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    /**
     * @param string|null $attachment
     *
     * @return Message
     */
    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function addDevice(string $name): self
    {
        if (null === $this->device) {
            $this->device = [];
        }

        $this->device[] = $name;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getDevices(): ?array
    {
        return $this->device;
    }

    /**
     * @param array|null $device
     *
     * @return Message
     */
    public function setDevices(?array $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return Message
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     *
     * @return Message
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlTitle(): ?string
    {
        return $this->urlTitle;
    }

    /**
     * @param string|null $urlTitle
     *
     * @return Message
     */
    public function setUrlTitle(?string $urlTitle): self
    {
        $this->urlTitle = $urlTitle;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     *
     * @return Message
     */
    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSound(): ?string
    {
        return $this->sound;
    }

    /**
     * @param string|null $sound
     *
     * @return Message
     */
    public function setSound(?string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getTimestamp(): ?DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * @param DateTimeInterface|null $timestamp
     *
     * @return Message
     */
    public function setTimestamp(?DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function fillBuilder(MultipartStreamBuilder $builder): MultipartStreamBuilder
    {
        if (null !== $this->appToken) {
            $builder->addResource('token', $this->appToken);
        }

        if (null !== $this->userToken) {
            $builder->addResource('user', $this->userToken);
        }

        $builder->addResource('message', $this->message);

        if (null !== $this->attachment) {
            $builder->addResource('attachment', fopen($this->attachment, 'rb'));
        }

        if (false === empty($this->device)) {
            $builder->addResource('device', implode(',', $this->device));
        }

        if (null !== $this->title) {
            $builder->addResource('title', $this->title);
        }

        if (null !== $this->url) {
            $builder->addResource('url', $this->url);
        }

        if (null !== $this->urlTitle) {
            $builder->addResource('url_title', $this->urlTitle);
        }

        if (null !== $this->priority) {
            $builder->addResource('priority', $this->priority);
        }

        if (null !== $this->sound) {
            $builder->addResource('sound', $this->sound);
        }

        if (null !== $this->timestamp) {
            $builder->addResource('timestamp', $this->timestamp->getTimestamp());
        }

        return $builder;
    }
}