<?php

namespace VkBot;

class KeyPhrase
{
    protected string $name;
    protected array $callback = [];

    public function __construct (string $name, callable $callback)
    {
        $this->name = mb_strtolower ($name);
        $this->callback[0] = $callback;
    }

    public function is (array $message): bool
    {
        return $this->name == mb_strtolower ($message['text']);
    }

    public function execute (array $message): void
    {
        $this->callback[0] ($message);
    }
}
