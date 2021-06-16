<?php

namespace VkBot;

use ConsoleArgs\Command;

return new Command ('музыка', function () use ($API, $message)
{
    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'https://open.spotify.com/playlist/4zmxI1gD8NsQij18Lw9HJ6?si=35d197c9ae9c479d'
    ]);
});
