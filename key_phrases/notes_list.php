<?php

namespace VkBot;

use VKAPI\VK;

return new KeyPhrase ('мои заметки', function ($message) use ($API)
{
    $notes = [];

    foreach (Notes::get ($message['from_id']) as $id => $note)
        $notes[] = '📓 №'. ($id + 1) .' | '. ($note['caption'] === null ? mb_substr ($note['note'], 0, 20) : $note['caption']);

    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => sizeof ($notes) > 0 ? 
            'Список ваших заметок:'. PHP_EOL . join (PHP_EOL, $notes) :
            'У вас нет сохраненных заметок'
    ]);
});
