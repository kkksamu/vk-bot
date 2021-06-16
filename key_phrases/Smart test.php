<?php

namespace VkBot;

use VKAPI\VK;

return new KeyPhrase ('тест на интеллектуала', function ($message) use ($API)
{
    global $handlers;

    $handlers[$message['from_id']]['pidor_test'] = function (array $message, VK $API, &$handlers) 
    {
        $API->messages->send ([
            'peer_id'   => $message['peer_id'],
            'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
            'message'   => match (mb_strtolower ($message['text']))
            {
                'никита' => 'не интеллектуал',
                'кирилл' => 'не интеллектуал',
                'не интеллектуал' => 'не интеллектуал',

                default => 'интеллектуал'
            }
        ]);

        unset ($handlers[$message['from_id']]['pidor_test']);

        return false;
    }; 

    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'Как вас зовут?'
    ]);
});
