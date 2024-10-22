<?php

namespace DEVMAN1917\Mattermost\Logger\Interfaces;

use DEVMAN1917\Mattermost\Logger\Values\Format;
use DEVMAN1917\Mattermost\Logger\Values\Level;
use DEVMAN1917\Mattermost\Logger\Values\Webhook;

interface Options
{
    public function webhook (): Webhook;
    public function level (): Level;
    public function channel (): string;
    public function titleFormat (): Format;
    public function titleMentionFormat (): Format;
    public function levelMention (): Level;
    public function username (): string;
    public function mentions (): array;
    public function shortFieldLength (): int;
    public function maxAttachmentLength (): int;
    public function iconUrl (): ?string;
}
