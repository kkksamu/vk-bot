<?php

namespace VkBot;

use ConsoleArgs\Command;

return new Command ('hello', function () use ($API, $message)
{
    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'u wrot "'. $message['text'] .'"'
    ]);
});
