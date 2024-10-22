<?php

namespace DEVMAN1917\Mattermost\Logger\Interfaces;

interface Scribe
{
    public function __construct (
        Message $message,
        Options $options,
        array $record
    );

    public function message (): Message;
}
