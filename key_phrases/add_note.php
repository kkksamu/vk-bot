<?php

namespace VkBot;

use VKAPI\VK;

return new KeyPhrase ('добавь заметку', function ($message) use ($API)
{
    global $handlers;

    $handlers[$message['from_id']]['add_note__caption_request'] = function (array $message, VK $API, &$handlers) 
    {
        $caption = $message['text'];

        $API->messages->send ([
            'peer_id'   => $message['peer_id'],
            'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
            'message'   => 'Введите содержимое заметки:'
        ]);

        unset ($handlers[$message['from_id']]['add_note__caption_request']);

        $handlers[$message['from_id']]['add_note__content_request'] = function (array $message, VK $API, &$handlers) use ($caption) 
        {
            Notes::add ($message['from_id'], $message['text'], mb_strtolower ($caption) == 'пропустить' ? null : $caption);

            $API->messages->send ([
                'peer_id'   => $message['peer_id'],
                'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
                'message'   => 'Заметка успешно добавлена'
            ]);
    
            unset ($handlers[$message['from_id']]['add_note__content_request']);
    
            return false;
        }; 

        return false;
    }; 

    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'Введите заголовок заметки ("пропустить" чтобы не добавлять название):'
    ]);
});
