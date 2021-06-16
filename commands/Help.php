<?php

namespace VkBot;

use ConsoleArgs\Command;

return new Command ('команды', function () use ($API, $message)
{
    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'Список доступных команд: 
        - расскажи анекдот
        - музыка
        - погода
        - тест на интеллектуала
        - красавчик
        - красавица
        - сенсей
        - песики
        - котики
        - тату
        - пейзажи
        - добавь заметку
        - мои заметку
        - покажи заметку
        - hello
        - write *встатьте какие-то слова*'
    ]);
});
