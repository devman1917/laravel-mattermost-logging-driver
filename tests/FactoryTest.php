<?php

namespace DEVMAN1917\Tests;

use DEVMAN1917\Mattermost\Logger\Factory;
use DEVMAN1917\Mattermost\Logger\Mattermost;
use GuzzleHttp\Client;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /** @test */
    public function invoking ()
    {
        $factory = new Factory(
            new Mattermost(new Client())
        );

        $logger = $factory([
            'webhook' => 'test-webhook'
        ]);

        $this->assertInstanceOf(Logger::class, $logger);
    }
}
