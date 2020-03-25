<?php

namespace AurimasNiekis\PushoverClient;

use Http\Message\MultipartStream\MultipartStreamBuilder;

/**
 * @package AurimasNiekis\PushoverClient
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Glance
{
    private ?string    $appToken;
    private ?string    $userToken;
    private ?array     $device;
    private ?string    $title;
    private ?string    $text;
    private ?string    $subText;
    private ?int       $count;
    private ?float      $percentage;


    public function __construct(string $userToken = null, string $appToken = null)
    {
        $this->appToken  = $appToken;
        $this->userToken = $userToken;

        $this->title      = '';
        $this->text       = '';
        $this->subText    = '';
        $this->count      = 0;
        $this->percentage = 0;
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
     * @return Glance
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
     * @return Glance
     */
    public function setUserToken(?string $userToken): self
    {
        $this->userToken = $userToken;

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
     * @return Glance
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
     * @return Glance
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     *
     * @return Glance
     */
    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubText(): ?string
    {
        return $this->subText;
    }

    /**
     * @param string|null $subText
     *
     * @return Glance
     */
    public function setSubText(?string $subText): self
    {
        $this->subText = $subText;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int|null $count
     *
     * @return Glance
     */
    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    /**
     * @param float|null $percentage
     *
     * @return Glance
     */
    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

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

        if (null !== $this->title) {
            $builder->addResource('title', $this->title);
        }

        if (null !== $this->text) {
            $builder->addResource('text', $this->text);
        }

        if (null !== $this->subText) {
            $builder->addResource('subtext', $this->subText);
        }

        if (null !== $this->count) {
            $builder->addResource('count', (string) $this->count);
        }

        if (null !== $this->percentage) {
            $builder->addResource('percentage', (string) $this->percentage);
        }

        if (false === empty($this->device)) {
            $builder->addResource('device', implode(',', $this->device));
        }

        return $builder;
    }
}