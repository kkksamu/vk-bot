<?php

namespace VkBot;

require 'vendor/autoload.php';
require 'KeyPhrase.php';
require 'src/Notes.php';

use VKAPI\{
    VK,
    LongPoll,
    Bot
};

use ConsoleArgs\{
    Manager,
    Command,
    DefaultCommand
};

$API      = new VK (file_get_contents ('vk_token'));
$longpoll = new LongPoll ($API);

global $handlers;

$handlers = [];
$keyPhrases = [];

foreach (glob (__DIR__ .'/key_phrases/*.php') as $keyPhrase)
    $keyPhrases[] = require $keyPhrase;

$bot = new Bot ($longpoll, function ($message) use ($API, $keyPhrases, &$handlers)
{
    if (($message['attachments'][0]['type'] ?? null) == 'sticker')
        return;
    
    foreach ($handlers as $user_id => $user_handlers)
        if ($user_id == $message['from_id'])
            foreach ($user_handlers as $handler)
                if ($handler ($message, $API, $handlers) === false)
                    return; 
    
    foreach ($keyPhrases as $keyPhrase)
        if ($keyPhrase->is ($message))
        {
            $keyPhrase->execute ($message);

            return;
        }

    $manager = new Manager;

    foreach (glob (__DIR__ .'/commands/*.php') as $command)
        $manager->addCommand (require $command);

    $manager->setDefault (require 'DefaultCommand.php')
            ->execute (Manager::parse ($message['text']));
});

while (true)
    $bot->update ();
