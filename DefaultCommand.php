<?php

use ConsoleArgs\DefaultCommand;

return new DefaultCommand (function ($args) use ($API, $message)
{
    echo 'Command "'. $args[0] .'" not found. You should write correct command name'. PHP_EOL;

    $API->messages->send ([
        'peer_id'    => $message['peer_id'],
        'random_id'  => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'    => 'такой команды не существует',
        'attachment' => 'video155923470_456239216'
    ]);

});
