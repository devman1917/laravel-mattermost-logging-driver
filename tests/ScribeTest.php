<?php

namespace DEVMAN1917\Tests;

use DEVMAN1917\Mattermost\Logger\DefaultMessage;
use DEVMAN1917\Mattermost\Logger\DefaultScribe;
use DEVMAN1917\Mattermost\Logger\Interfaces\Message;
use DEVMAN1917\Tests\Worlds\ScribeTestWorld;
use PHPUnit\Framework\TestCase;

class ScribeTest extends TestCase
{
    use ScribeTestWorld;

    /** @test */
    public function instantiating ()
    {
        $scribe = new DefaultScribe(
            new DefaultMessage(),
            $this->options(),
            []
        );

        $this->assertInstanceOf(DefaultScribe::class, $scribe);
    }

    /** @test */
    public function writing_a_message ()
    {
        $scribe = new DefaultScribe(
            new DefaultMessage(),
            $this->options(),
            $this->record()
        );

        $message = $scribe->message();

        $this->assertInstanceOf(Message::class, $message);
    }
}
