<?php

namespace AurimasNiekis\PushoverClient;

use AurimasNiekis\PushoverClient\Exception\InvalidRequestException;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @package AurimasNiekis\PushoverClient
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Client
{
    public const API_DOMAIN = 'https://api.pushover.net/1';

    private ClientInterface         $client;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface  $streamFactory;
    private ?string                 $appToken;
    private ?string                 $userToken;
    private string                  $apiDomain;

    /**
     * @param ClientInterface         $client
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface  $streamFactory
     * @param string|null             $appToken
     * @param string|null             $userToken
     * @param string                  $apiDomain
     */
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $appToken = null,
        string $userToken = null,
        string $apiDomain = self::API_DOMAIN
    ) {
        $this->client         = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory  = $streamFactory;
        $this->appToken       = $appToken;
        $this->userToken      = $userToken;
        $this->apiDomain      = $apiDomain;
    }

    public function sendMessage(Message $message): string
    {
        $builder = new MultipartStreamBuilder($this->streamFactory);

        if (null !== $this->appToken && null === $message->getAppToken()) {
            $builder->addResource('token', $this->appToken);
        }

        if (null !== $this->userToken && null === $message->getUserToken()) {
            $builder->addResource('user', $this->userToken);
        }

        $builder  = $message->fillBuilder($builder);

        return $this->send('/messages.json', $builder);
    }

    public function sendGlance(Glance $glance): string
    {
        $builder = new MultipartStreamBuilder($this->streamFactory);

        if (null !== $this->appToken && null === $glance->getAppToken()) {
            $builder->addResource('token', $this->appToken);
        }

        if (null !== $this->userToken && null === $glance->getUserToken()) {
            $builder->addResource('user', $this->userToken);
        }

        $builder = $glance->fillBuilder($builder);

        return $this->send('/glances.json', $builder);
    }

    private function send(string $path, MultipartStreamBuilder $builder): string
    {
        $stream   = $builder->build();
        $boundary = $builder->getBoundary();

        $request = $this->requestFactory->createRequest('POST', $this->apiDomain . $path);

        $request = $request
            ->withAddedHeader('Content-Type', 'multipart/form-data; boundary="' . $boundary . '"')
            ->withBody($stream);

        $response = $this->client->sendRequest($request);
        $json     = $response->getBody()->getContents();
        $data     = json_decode($json, true, JSON_THROW_ON_ERROR);

        if (200 === $response->getStatusCode() && ($data['status'] ?? '') === 1) {
            return $data['request'];
        } else {
            throw new InvalidRequestException();
        }
    }
}
