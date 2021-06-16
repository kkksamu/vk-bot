<?php

namespace VkBot;

return new KeyPhrase ('расскажи анекдот', function ($message) use ($API)
{
    $jokes = require 'src/jokes.php';

    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => $jokes[rand (0, sizeof ($jokes) - 1)]
    ]);
});
