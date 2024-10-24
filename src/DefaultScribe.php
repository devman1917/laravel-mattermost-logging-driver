<?php

namespace DEVMAN1917\Mattermost\Logger;

use DEVMAN1917\Mattermost\Logger\Interfaces\Message;
use DEVMAN1917\Mattermost\Logger\Interfaces\Options;
use DEVMAN1917\Mattermost\Logger\Interfaces\Scribe;
use DEVMAN1917\Mattermost\Logger\Values\Level;
use Illuminate\Support\Str;

final class DefaultScribe implements Scribe
{
    /** @var array */
    private $record;

    /** @var array */
    private $context;

    /** @var ?\Exception */
    private $exception;

    /** @var \DEVMAN1917\Mattermost\Logger\Interfaces\Options */
    private $options;

    /** @var \DEVMAN1917\Mattermost\Logger\Interfaces\Message */
    private $message;

    public function __construct(
        Message $message,
        Options $options,
        array $record
    )
    {
        $this->options = $options;
        $this->message = $message;

        $this->setRecord($record);
        $this->setContext($record);
        $this->setException($record);
    }

    public function message (): Message
    {
        $this->message->channel($this->options->channel());
        $this->message->username($this->options->username());
        $this->message->iconUrl($this->options->iconUrl());
        $this->message->text($this->title());

        if ($this->exception) {
            $this->message->addExceptionAttachment(
                $this->exception,
                $this->options->maxAttachmentLength()
            );
        }

        if ($this->context) {
            $this->message->addContextAttachment(
                $this->context,
                $this->options->shortFieldLength()
            );
        }

        return $this->message;
    }

    public function title (): string
    {
        $title = $this->options->titleFormat()->apply(
            $this->record['level_name'], $this->record['message']
        );

        if ($this->shouldMention()) {
            $title .= $this->options->titleMentionFormat()->apply(
                $this->mentions()
            );
        }

        return $title;
    }

    private function shouldMention (): bool
    {
        return Level::of($this->record['level'])->isGreaterThanOrEqualTo(
            $this->options->levelMention()
        );
    }

    /**
     * TODO: Refactor this to a value object.
     */
    public function mentions (): string
    {
        $mentions = array_map(function ($mention) {
            return Str::start($mention, '@');
        }, $this->options->mentions());

        return implode(', ', $mentions);
    }

    private function setRecord (array $record): void
    {
        if (isset($record['context'])) {
            unset($record['context']);
        }

        $this->record = $record;
    }

    private function setContext (array $record): void
    {
        if (isset($record['context']['exception'])) {
            unset($record['context']['exception']);
        }

        if (isset($record['context']) && count($record['context'])) {
            $this->context = $record['context'];
        }
    }

    private function setException (array $record): void
    {
        if (isset($record['context']['exception'])) {
            $this->exception = $record['context']['exception'];
        }
    }
}
