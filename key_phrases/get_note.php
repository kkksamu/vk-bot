<?php

namespace VkBot;

use VKAPI\VK;

return new KeyPhrase ('покажи заметку', function ($message) use ($API)
{
    global $handlers;

    $handlers[$message['from_id']]['get_note'] = function (array $message, VK $API, &$handlers) 
    {
        $note = Notes::get ($message['from_id'], $message['text'] - 1);

        $API->messages->send ([
            'peer_id'   => $message['peer_id'],
            'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
            'message'   => $note === null ? 
                'Заметки с таким номером не существует' :
                ($note['caption'] === null ? $note['note'] : 
                    $note['caption'] . PHP_EOL . PHP_EOL . $note['note'])
        ]);

        unset ($handlers[$message['from_id']]['get_note']);

        return false;
    };

    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'Введите номер заметки:'
    ]);
});
