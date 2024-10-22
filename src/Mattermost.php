<?php

namespace DEVMAN1917\Mattermost\Logger;

use DEVMAN1917\Mattermost\Logger\Interfaces\Message;
use DEVMAN1917\Mattermost\Logger\Values\Webhook;
use GuzzleHttp\Client;

final class Mattermost
{
    /** @var \GuzzleHttp\Client */
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function send (Message $message, Webhook $webhook)
    {
        $this->http->post(
            $webhook->value(),
            [
                'json' => $message->toArray(),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }
}
